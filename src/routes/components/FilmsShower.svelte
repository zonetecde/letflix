<script lang="ts">
	import { createEventDispatcher, onMount } from 'svelte';
	import type Movie from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';
	import ShowButton from './ShowButton.svelte';
	import { watchMovie } from '../../models/Store';

	export let sql: string;
	export let sectionTitle: string;
	export let tableName: string;
	export let args: string | undefined = undefined;

	$: sectionTitle, (matchedMovies = []);

	let matchedMovies: Movie[] = [];

	// Récupère les films les mieux notés
	const handleProcessRequestion = async () => {
		if (args !== '' && args !== undefined)
			window.history.pushState('page4', 'sql', '/page4.php?acteur=' + args);

		const tempMatchedMovies: Movie[] = await FetchDB(sql, tableName);

		// Récupère les images des films si elles n'ont pas déjà été récupérées
		await Promise.all(
			tempMatchedMovies.map(async (movie: Movie) => {
				const result = await GetPosterPath(movie.Title, movie.ReleaseDate);
				movie.PosterImg = result || '';
			})
		).then(() => {
			matchedMovies = tempMatchedMovies;
		});
	};

	function handleWatchMovieButtonClicked() {
		watchMovie.set(true);
	}
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800 overflow-x-auto horizontal-scrollbar overflow-y-hidden"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if matchedMovies.length === 0}
		<ShowButton on:processRequestion={handleProcessRequestion} {sql} />
	{:else}
		<div class="flex flex-row mt-3 gap-x-2">
			{#each matchedMovies as movie}
				<button
					class="relative duration-150 min-w-[200px] max-w-[200px] flex flex-col border-2 border-red-400 hover:z-50 hover:scale-110 cursor-pointer"
					on:click={handleWatchMovieButtonClicked}
				>
					<p class="w-full text-white bg-black text-center">{movie.Title}</p>

					<img alt="Poster du film" src={movie.PosterImg} class="object-cover h-full" />
				</button>
			{/each}
		</div>
	{/if}
</section>
