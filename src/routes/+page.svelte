<script lang="ts">
	import { onMount } from 'svelte';
	import AppVariables from '../AppVariables';
	import type Movie from '../models/Movie';
	import { FetchDB, FindFromTMDB } from '../Extensions/Fetcher';

	let bestMovies: Movie[] = [];

	// Récupère les films les mieux notés
	onMount(async () => {
		const tempBestMovies = await FetchDB(
			'SELECT * FROM topratedmovies ORDER BY VoteAverage desc LIMIT 15'
		);

		// Récupère les images des films
		for (let i = 0; i < tempBestMovies.length; i++) {
			const movie = tempBestMovies[i];
			const result = await FindFromTMDB(movie.Title, movie.ReleaseDate);
			movie.PosterImg = 'https://image.tmdb.org/t/p/original' + (result.poster_path || '');
		}

		console.log(tempBestMovies);
		bestMovies = tempBestMovies;
	});
</script>

<div class="w-full h-full bg-[#532727] text-black p-4">
	<section
		class="flex flex-col border-2 border-gray-600 rounded-b-xl h-48 px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
	>
		<p class="font-bold">Nos films les mieux notés...</p>

		<div class="flex flex-row">
			{#each bestMovies as movie}
				<div class="flex flex-row items-center gap-2">
					<img alt="Poster du film" src={movie.PosterImg} class="h-20 w-20 object-contain" />
					<p class="font-bold">{movie.Title}</p>
				</div>
			{/each}
		</div>
	</section>
</div>
