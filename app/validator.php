<?php

class HMIFValidator extends \Illuminate\Validation\Validator {

    public function validateNim($attribute, $value, $parameters)
    {
        if(strlen($value) === 8)
        {
            $fakultas = (int) $value[0];
            $prodi = $value[1] . '' . $value[2];
            $angkatan = (int) ($value[3] . '' . $value[4]);
            $urutan = (int) ($value[5] . '' . $value[6] . '' . $value[7]);
            $valid = FALSE;

            switch($fakultas)
            {
                case 1: // TEKNIK
                    $listprodi = array(
                                    '01', // IF
                                    '02', // TEKOM
                                    '03', // TEKINDUSTRI
                                    '04', // ARSITEK
                                    '05', // MI
                                    '06', // WILKOT
                                    '08', // TEKOM D3
                                    '09', // MI D3
                                    '10', // KOM AK D3
                                    '30', // TEKSIPIL
                                    '31', // ELEKTRO
                                    '40', // SI
                                );
                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;

                case 2: // EKONOMI
                    $listprodi = array(
                                    '11', // AK
                                    '12', // MANAJEMEN
                                    '41', // AKSYARIAH
                                    '42', // MANAJEMENRS
                                    '13', // AK D3
                                    '14', // MANPES D3
                                    '15', // KEUANGAN
                                );

                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;

                case 3: // HUKUM
                    $listprodi = array(
                                    '16', // HUKUM
                                );

                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;

                case 4: // SOSPOL
                    $listprodi = array(
                                    '18', // IK
                                    '43', // ILMUHUBINT
                                    '17', // ILMUPEMERINTAHAN
                                    '33', // PUBLIC RELATION
                                );

                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;

                case 5: // DESAIN
                    $listprodi = array(
                                    '19', // DKV
                                    '20', // INTERIOR
                                    '21', // DKV D3
                                );

                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;

                case 6: // SASTRA
                    $listprodi = array(
                                    '37', // ING
                                    '38', // JPG
                                );

                    if(in_array($prodi, $listprodi)) $valid = TRUE;

                    break;
            }

            if(! $valid) return FALSE;

            $tahun = (int) date('y');

            if($angkatan > $tahun) return FALSE;

            return TRUE;
        }

        return FALSE;
    }

    public function validateNimIf($attribute, $value, $parameters)
    {
        if ($parameters[1] == array_get($this->data, $parameters[0]))
        {
            return $this->validateNim($attribute, $value, $parameters);
        }

        return TRUE;
    }

    public function validateUniqueIf($attribute, $value, $parameters)
    {
        $table = $parameters[0];
        $field = $parameters[1];
        $field_name = $parameters[2];
        $field_value = $parameters[3];

        if ($field_value == array_get($this->data, $field_name))
        {
            return TRUE;
        }
        else
        {
            $result = DB::select('SELECT * FROM '.$table.' WHERE '.$attribute.' = '.$value.' AND '.$field.' = \''.array_get($this->data, $field).'\'');

            if($result)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }       
        }
    }
}

Validator::resolver(function($translator, $data, $rules, $messages)
{
    return new HMIFValidator($translator, $data, $rules, $messages);
});