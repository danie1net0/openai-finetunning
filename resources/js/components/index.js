import { Alpine } from '../../../vendor/livewire/livewire/dist/livewire.esm';

import Toast from './toast';

window.Toast = Toast;

Alpine.data('toast', Toast);
