<?php

namespace App\Http\Livewire\Dashboard\Client\Index;

use App\Core\Extensions\V2ray\Models\Inbound;
use App\Models\Country;
use App\Models\Option;
use App\Models\Server;
use App\Core\Extensions\V2ray\Models\Protocol;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component {
    public User $user;
    public function mount(User $user) {
        if (!$user->isClient() || auth()->user()->id != $user->id && !auth()->user()->can('view-client-overview')) {
            abort(404);
        }
    }

    public function render() {
        return view('livewire.dashboard.client.index.index');
    }

}
