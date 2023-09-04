<?php


namespace App\Core\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string data_key
 * @property string data_value
 * @method HasMany data()
 */

trait HasData
{
    /**
     * Retrieves data from `data` table
     * @param string $key
     * @param bool $self
     * @return mixed
     */
    public function getData(string $key, bool $self = false): mixed
    {
        $key = strtolower($key);
        $data = $this->data()->whereRaw("LOWER(`data_key`) = '$key'")->first();
        if ($self) {
            return $data;
        }
        if ($data != null) {
            if (!empty($data->data_value)) {
                return $data->data_value;
            }
        }
        return null;
    }

    /**
     * Updates or create data from `data` table
     * @param string $key
     * @param string|null $value
     * @return Model|int
     */
    public function setData(string $key, string $value = null): Model|int
    {
        if($value == null) {
            return $this->data()->where('data_key', $key)->delete();
        }
        return $this->data()->updateOrCreate([
            'data_key' => strtolower($key)
        ], [
            'data_value' => $value
        ]);
    }

    /**
     * Deletes data from `data` table
     * @param string $key
     * @return bool
     */
    public function deleteData(string $key): bool {

        $this->data()->where('data_key', $key)?->delete();

        return true;
    }


}
