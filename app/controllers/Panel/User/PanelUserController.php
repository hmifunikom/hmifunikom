<?php

use HMIF\Model\User\User;

class PanelUserController extends BaseController {

    private $user;

    public function __construct(UserRepoInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = $this->user->findAll();
        return View::make('panel.pages.user.index')->with(array('listuser' => $user));
    }

}