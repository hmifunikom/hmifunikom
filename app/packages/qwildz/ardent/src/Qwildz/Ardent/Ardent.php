<?php namespace Qwildz\Ardent;

/*
 * This file is part of the Ardent package.
 *
 * (c) Max Ehsan <contact@laravelbook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use LaravelBook\Ardent\Ardent as RealArdent;
use Frozennode\XssInput\XssInput as Input;

/**
 * Ardent - Self-validating Eloquent model base class
 *
 */
abstract class Ardent extends RealArdent {

    /**
     * Validate the model instance
     *
     * @param array $rules          Validation rules
     * @param array $customMessages Custom error messages
     * @return bool
     * @throws InvalidModelException
     */
    public function validate(array $rules = array(), array $customMessages = array()) {
        if ($this->fireModelEvent('validating') === false) {
            if ($this->throwOnValidation) {
                throw new InvalidModelException($this);
            } else {
                return false;
            }
        }

        // check for overrides, then remove any empty rules
        $rules = (empty($rules))? static::$rules : $rules;
        foreach ($rules as $field => $rls) {
            if ($rls == '') {
                unset($rules[$field]);
            }
        }

        if (empty($rules)) {
            $success = true;
        } else {
			$customMessages = (empty($customMessages))? static::$customMessages : $customMessages;

			if ($this->forceEntityHydrationFromInput || (empty($this->attributes) && $this->autoHydrateEntityFromInput)) {
				$this->fill(Input::all());
			}

			$data = $this->getAttributes(); // the data under validation

			// perform validation
			$validator = static::makeValidator($data, $rules, $customMessages);
			$success   = $validator->passes();

			if ($success) {
				// if the model is valid, unset old errors
				if ($this->validationErrors->count() > 0) {
					$this->validationErrors = new MessageBag;
				}
			} else {
				// otherwise set the new ones
				$this->validationErrors = $validator->messages();

				// stash the input to the current session
				if (!self::$externalValidator && Input::hasSession()) {
					Input::flash();
				}
			}
		}

        $this->fireModelEvent('validated', false);

	    if (!$success && $this->throwOnValidation) {
		    throw new InvalidModelException($this);
	    }

        return $success;
    }
}
