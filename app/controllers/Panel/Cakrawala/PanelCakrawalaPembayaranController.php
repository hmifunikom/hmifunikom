<?php

use HMIF\Model\Cakrawala\TcrPeserta;
use HMIF\Model\Cakrawala\Pembayaran;
use HMIF\Repositories\Cakrawala\PembayaranRepoInterface;

class PanelCakrawalaPembayaranController extends BaseController
{
    private $pembayaran;

    public function __construct(PembayaranRepoInterface $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        if(Input::has('bayar'))
            $pembayaran = $this->pembayaran->findByBayar(Input::get('bayar'));
        else
            $pembayaran = $this->pembayaran->findAll();

        if(Input::has('s'))
        {
            $newpembayaran = $pembayaran->filter(function($bayar)
            {
                $pembayar = $bayar->payment;
                if($pembayar instanceof HMIF\Model\Cakrawala\Tim)
                {
                    if(str_contains(strtolower($pembayar->nama_tim), strtolower(Input::get('s')))){
                        return true;
                    }
                }
                else
                {

                    if(str_contains(strtolower($pembayar->nama_peserta), strtolower(Input::get('s')))){
                        return true;
                    }
                }

            });

            $pembayaran = Paginator::make($newpembayaran->all(), $newpembayaran->count(), 15);
        }


        return View::make('panel.pages.cakrawala.pembayaran.index')->with(array('pembayaran' => $pembayaran));
    }

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function create()
    {
        return Redirect::back();
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store()
    {
        return Redirect::back();
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($pembayaran)
    {
        return Response::download(Helper::pathFile($pembayaran->bukti_bayar, true));
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($pembayaran)
    {
        return Redirect::back();
    }

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($pembayaran)
    {
        return Redirect::back();
    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($pembayaran)
    {
        return Redirect::back();
    }

    public function verified($pembayaran)
    {
        $pembayaran->setVerified();

        if ($pembayaran->updateUniques()) {
            $pembayar = $pembayaran->payment;
            $email = $pembayar->user->email;

            if ($email) {
                if ($pembayar instanceof HMIF\Model\Cakrawala\Tim) {
                    Mail::send('emails.cakrawala.confirmation-success', array(), function ($message) use ($email, $pembayar) {
                        $message->to($email, $pembayar->nama_tim)->subject('[CAKRAWALA] Status Pembayaran - HMIF Unikom');
                    });
                } else {
                    Mail::send('emails.cakrawala.confirmation-success-tcr', array(), function ($message) use ($email, $pembayar) {
                        $message->to($email, $pembayar->nama_peserta)->subject('[CAKRAWALA] Status Pembayaran - HMIF Unikom');
                    });
                }
            }

            return Redirect::back()->with('success', 'Berhasil mengubah status pembayaran!');
        } else {
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
    }

    public function invalid($pembayaran)
    {
        $pembayaran->setInvalid();

        if ($pembayaran->updateUniques()) {
            $pembayar = $pembayaran->payment;
            if($pembayar instanceof HMIF\Model\Cakrawala\Tim)
                $rcpt = $pembayar->nama_tim;
            else
                $rcpt = $pembayar->nama_peserta;

            $email = $pembayar->user->email;

            if ($email) {
                Mail::send('emails.cakrawala.confirmation-fail', array(), function ($message) use ($email, $rcpt) {
                    $message->to($email, $rcpt)->subject('[CAKRAWALA] Status Pembayaran - HMIF Unikom');
                });
            }

            return Redirect::back()->with('success', 'Berhasil mengubah status pembayaran!');
        } else {
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
    }

    public function kuitansi($peserta)
    {
        if(!($peserta instanceof TcrPeserta)) return Redirect::back();

        $p = $peserta->pembayaran;
        if($p->getPaymentStatus() != $p::PAYMENT_VERIFIED) return Redirect::back();

        $kode = Helper::code($peserta->kode, 'TCR-', 3);
        Helper::createQR($kode);
        $html =  View::make('pages.cakrawala.kuitansi')->with(array('peserta' => $peserta, 'kode' => $kode))->render();
        $filename = Str::slug($kode);

        $pdf = PDF::loadHTML($html);

        return $pdf->download($kode.'.pdf');
    }
}
