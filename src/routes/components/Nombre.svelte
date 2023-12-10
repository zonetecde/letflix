<script lang="ts">
	import { onMount } from 'svelte';
	import type number from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';
	import ShowButton from './ShowButton.svelte';

	export let sql: string;
	export let sectionTitle: string;
	export let roundResult: boolean = true;

	let counter: number;
	let counter_updated: number = 0;

	function updateCounter() {
		if (counter_updated >= counter) {
			counter_updated = counter;
			return;
		} else {
			setTimeout(() => {
				counter_updated += counter / (counter > 1000 ? 1000 : 300);
				updateCounter();
			}, 1);
		}
	}

	// Récupère le nombre de la requête
	const handleProcessRequestion = async () => {
		counter = (await FetchDB(sql))[0]._count;

		updateCounter();
	};
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if counter === undefined}
		<ShowButton on:processRequestion={handleProcessRequestion} {sql} />
	{:else}
		<div
			class={'flex flex-row items-center border-2 justify-center overflow-x-auto mt-1 mb-1 horizontal-scrollbar overflow-y-hidden gap-x-2 h-[75px] w-[160px] bg-orange-200 rounded-2xl ' +
				(counter_updated === counter ? 'border-green-800' : 'border-red-800')}
		>
			<p class="font-bold text-xl">
				{roundResult ? Math.round(counter_updated) : counter_updated.toFixed(3)}
			</p>
		</div>
	{/if}
</section>
