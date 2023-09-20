import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import address from "./address.js";

Alpine.data("address", address);

Livewire.start();

// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}
