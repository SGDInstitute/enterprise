import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import address from "./address.js";

Alpine.data("address", address);

Livewire.start();
