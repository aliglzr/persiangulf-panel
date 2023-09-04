<?php

namespace App\Core\Traits;

trait Encryptable {
    /**
     * If the attribute is in the encryptable array
     * then decrypt it.
     *
     * @param $key
     *
     * @return mixed $value
     */
    public function getAttribute($key): mixed {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptable) && $value !== '') {
            try {
                $res = decrypt($value);
            } catch (\Exception) {
                $res = $value;
            }
            $value = $res;
        }
        return $value;
    }

    /**
     * If the attribute is in the encryptable array
     * then encrypt it.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value): mixed {
        if (in_array($key, $this->encryptable)) {
            try {
                $res = encrypt($value);
            } catch (\Exception) {
                $res = $value;
            }
            $value = $res;
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * When need to make sure that we iterate through
     * all the keys.
     *
     * @return array
     */
    public function attributesToArray(): array {
        $attributes = parent::attributesToArray();
        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }
}
