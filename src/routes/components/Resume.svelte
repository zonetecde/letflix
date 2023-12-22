<script lang="ts">
	import { onMount } from 'svelte';
	import type Movie from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';
	import ShowButton from './ShowButton.svelte';

	export let sql: string;
	export let sectionTitle: string;
	export let tableName: string;
	export let args: string | undefined = undefined;

	let requestFailed: boolean = false;

	$: sectionTitle, (movie = undefined);
	$: sectionTitle, (requestFailed = false);

	let movie: Movie | undefined = undefined;

	// Récupère le résumé du film
	const handleProcessRequestion = async () => {
		if (args !== '' && args !== undefined)
			window.history.pushState('page4', 'sql', '/page4.php?acteur=' + args);

		movie = (await FetchDB(sql, tableName))[0];

		if (movie === undefined) {
			requestFailed = true;
			return;
		}

		const result = await GetPosterPath(movie.Title, movie.ReleaseDate);
		movie.PosterImg = result || '';
	};
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if requestFailed === false}
		{#if movie === undefined}
			<ShowButton on:processRequestion={handleProcessRequestion} {sql} />
		{:else}
			<div
				class="flex flex-row overflow-x-auto mt-3 horizontal-scrollbar overflow-y-hidden gap-x-2 pb-2 h-[300px]"
			>
				<img
					alt="Poster du film"
					src={movie.PosterImg}
					class="object-cover w-[250px] h-full border-2 border-black"
				/>
				<div class="flex flex-col overflow-auto">
					<h1 class="font-bold text-3xl">{movie.Title}</h1>
					<p class="mt-2 max-w-[600px]">
						<span class="font-bold">Description :</span><br />{movie.Overview.replaceAll(
							'\\"',
							'"'
						)}
					</p>
				</div>
			</div>
		{/if}
	{:else}
		<p class="text-red-800 font-bold mt-2">Ce film n'existe pas dans la table 'topratedmovies'</p>
	{/if}
</section>
