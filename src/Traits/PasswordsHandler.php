<?php

namespace CrudBuilder\Traits;

use Illuminate\Support\Facades\Hash;

trait PasswordsHandler
{
    
    public function hashPasswords(array $resourceInputs, array $requestInputs)
    {
        $passwords = $this->getPasswords($resourceInputs);
        
        return collect($requestInputs)
            ->map(function($input, $index) use($passwords) {
                if(in_array($index, $passwords)) {
                    return Hash::make($input);
                }
                
                return $input;
            })
            ->toArray();
    }

    /**
     * Return the names of the inputs of type password.
     *
     * @return array
     */
    protected function getPasswords(array $resourceInputs)
    {
        return collect($resourceInputs)
            ->filter(fn($input) => $input->type === 'text' && $input->textType === 'password')
            ->pluck('name')
            ->toArray();
    }
}