<script>
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
	import { modal } from '../../models/Store';

	let onMovieScreen = false;
	function handleWatchMovie() {
		onMovieScreen = true;
	}

	function handlePublicityCloseButtonClicked() {
		// Va vers la page d'achat
		modal.set(
			"Votre commande de 94 mousse à raser XILON <i>pour un rasage parfait</i> de valeur 4109 euros a bien été prise en compte. Vous les recevrez d'ici 3 à 4 jours ouvrés."
		);
	}
</script>

<div
	class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar grid grid-cols-8 lg:grid-cols-10 gap-x-2"
>
	<div class="col-span-7 lg:col-span-9">
		<PageSwitcher page={1} />

		<Carrousel
			sql="SELECT * FROM 'topratedmovies' where title like 'Star Wars%';"
			sectionTitle="Nos films Star Wars"
			tableName="topratedmovies"
			on:watchMovie={handleWatchMovie}
		/>
		<br />

		<Carrousel
			sql="SELECT * FROM 'bestmoviesnetflix' where RELEASE_YEAR < 2000 and score > 8.0;"
			sectionTitle="Les films avant 2000 avec un score supérieur à 8/10"
			tableName="bestmoviesnetflix"
		/>

		<br />

		<TextShower
			sectionTitle="Tout les genres parmis les meilleurs séries... <sm class='text-sm italic'>(puisque j'ai fait un joli carrousel je n'ai pas limité les résultats à 10)</sm> :"
			sql="SELECT DISTINCT MAIN_GENRE as _text FROM 'bestshowsnetflix'; -- LIMIT 10"
			tableName="text"
		/>

		<br />

		<Resume
			sql="SELECT * FROM 'topratedmovies' where Title like '%Spider-Man%' ORDER BY VoteAverage desc LIMIT 1;"
			sectionTitle="La description du film Spider-Man le mieux noté :"
			tableName="topratedmovies"
		/>
	</div>
	{#if onMovieScreen}
		<iframe
			class="absolute bottom-0 left-0 right-0 top-0"
			src="https://www.youtube.com/embed/0KW8stZ2jSQ?autoplay=1&mute=1&controls=0&loop=1&playlist=0KW8stZ2jSQ"
			allow="autoplay; encrypted-media"
			allowfullscreen
		></iframe>
	{/if}

	<div class="col-span-1 flex items-center border-2 border-black bg-black relative">
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
		<img
			src="ad1.png"
			alt="Publicité"
			class="w-full cursor-pointer"
			on:click={() =>
				window.open('https://www.franprix.fr/courses/p/mousse-a-raser-peaux-sensibles-99193042')}
		/>
		<button
			on:click={handlePublicityCloseButtonClicked}
			class="absolute top-0 left-0 w-6 h-6 bg-red-600 text-white text-xl font-bold flex items-center justify-center"
			>X
		</button>
	</div>
</div>
