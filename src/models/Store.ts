import { writable } from 'svelte/store';

export const modal = writable('');

function increment(modalText: string) {
	modal.update((n) => modalText);
}

function reset() {
	modal.set('');
}
