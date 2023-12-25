<script lang="ts">
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
	import { modal } from '../../models/Store';
	import { onMount } from 'svelte';
	import { FetchDB } from '../../Extensions/Fetcher';

	let actorsName: string[] = [];
	let typedActorName: string = '';
	let comparaisonExacte: boolean = true;

	$: sqlMovies = `SELECT distinct titles.* FROM titles, credits where titles.id = credits.id and LOWER(credits.name) ${
		!comparaisonExacte ? 'LIKE' : '='
	} '${
		(!comparaisonExacte ? '%' : '') + typedActorName.toLowerCase() + (!comparaisonExacte ? '%' : '')
	}' LIMIT 20;`;
	$: sectionTitleMovies = `Les titres des films où ${typedActorName} a joué :`;
	const tableName = 'titles';

	// le résumé du dernier film sorti de l'acteur dans la base titles
	$: sqlDescription = `SELECT topratedmovies.* FROM titles, credits, topratedmovies where titles.id = credits.id and titles.title = topratedmovies.title and LOWER(credits.name) ${
		!comparaisonExacte ? 'LIKE' : '='
	} '${
		(!comparaisonExacte ? '%' : '') + typedActorName.toLowerCase() + (!comparaisonExacte ? '%' : '')
	}' ORDER BY titles.release_year DESC LIMIT 1;`;

	$: sectionTitleDescription = `Le résumé du dernier film sorti de ${typedActorName} :`;

	onMount(async () => {
		const actors: any[] = await FetchDB('select distinct name as _name from credits');
		actorsName = actors.map((actor) => actor._name);
	});
</script>

<div
	class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar grid grid-cols-8 lg:grid-cols-10 gap-x-2"
>
	<div class="col-span-1 flex items-center border-2 border-black bg-black relative">
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
		<img
			src="ad4.png"
			alt="Publicité"
			class="w-full cursor-pointer"
			on:click={() =>
				window.open(
					'https://fr.louisvuitton.com/fra-fr/produits/mocassin-lv-met-nvprod4280010v/1ABN3V?campaign=sem_LV_FLG_FRA_ALWON_MIXT_FRAG_OnGoing_EC_BRAN_GSHA_MUL_FRA_EUR_NOMT_&utm_source=google&utm_medium=cpc&utm_campaign=LV_FLG_FRA_ALWON_MIXT_FRAG_OnGoing_EC_BRAN_GSHA_MUL_FRA_EUR_NOMT_&utm_term=&gad_source=1&gclid=Cj0KCQiAsvWrBhC0ARIsAO4E6f-ZLB8adAw6H3qJvFXNru4s_vhQ8-_zohjgYZ3Y6R430UpEzM1rjGcaAhgzEALw_wcB'
				)}
		/>
	</div>

	<div class="col-span-7 lg:col-span-9">
		<PageSwitcher page={4} />

		<div class="flex flex-col items-center justify-center gap-2">
			<input
				type="text"
				list="actors"
				placeholder="Nom de l'acteur"
				class="w-1/2 h-10 px-2 border-2 border-black rounded-md"
				bind:value={typedActorName}
			/>
			<datalist id="actors">
				{#each actorsName as actor}
					<option value={actor} />
				{/each}
			</datalist>

			<label class="text-white flex items-center gap-x-2">
				<input type="checkbox" class="h-5 w-5" bind:checked={comparaisonExacte} />
				Comparaison exacte ?
			</label>

			<i class="text-white opacity-60"
				>La requête GET s'effectue lors du clique sur les boutons 'Charger...'</i
			>
		</div>

		<br />

		<Carrousel
			sql={sqlMovies}
			sectionTitle={sectionTitleMovies}
			{tableName}
			args={typedActorName}
		/>

		<br />

		<Resume
			sql={sqlDescription}
			sectionTitle={sectionTitleDescription}
			tableName={'topratedmovies'}
			args={typedActorName}
		/>
	</div>
</div>
