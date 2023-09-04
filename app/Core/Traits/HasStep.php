<?php


namespace App\Core\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string data_key
 * @property string data_value
 * @method HasMany data()
 */
trait HasStep {
    /**
     * Retrieves bot step from `data` table
     * @return mixed
     */
    public function getStep(): mixed {
        $data = $this->data()->where('data_key', 'sales_bot_step')->first();
        if ($data != null) {
            if (!empty($data->data_value)) {
                return $data->data_value;
            }
        }
        return null;
    }

    /**
     * Updates or create bot step from `data` table
     * @param string|null $value
     * @return Model|int
     */
    public function setStep(string $value = null): Model|int {
        if ($value == null) {
            return $this->data()->where('data_key', 'sales_bot_step')?->delete();
        }
        return $this->data()->updateOrCreate([
            'data_key' => 'sales_bot_step'
        ], [
            'data_value' => $value
        ]);
    }

    /**
     * Deletes bot step from `data` table
     * @return bool
     */
    public function deleteStep(): bool {

        $this->data()->where('data_key', 'sales_bot_step')?->delete();

        return true;
    }


}
