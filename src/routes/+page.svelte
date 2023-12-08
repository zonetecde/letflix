<script lang="ts">
	import FilmsMieuxNotes from './components/FilmsShower.svelte';
	import TextShower from './components/TextShower.svelte';
</script>

<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar">
	<FilmsMieuxNotes
		sql="SELECT * FROM 'topratedmovies' where title like 'Star Wars%';"
		sectionTitle="Nos films Star Wars"
		tableName="topratedmovies"
	/>
	<br />

	<FilmsMieuxNotes
		sql="SELECT * FROM 'bestmoviesnetflix' where RELEASE_YEAR < 2000 and score > 8.0;"
		sectionTitle="Les films avant 2000 avec un score supérieur à 8/10"
		tableName="bestmoviesnetflix"
	/>

	<br />

	<TextShower
		sectionTitle="Tout les genres parmis les meilleurs séries... :"
		sql="SELECT DISTINCT MAIN_GENRE as _TEXT FROM 'bestshowsnetflix';"
		tableName="text"
	/>

	<br />

	<FilmsMieuxNotes
		sql="SELECT * FROM topratedmovies ORDER BY VoteAverage desc LIMIT 15;"
		sectionTitle="Nos films les mieux notés..."
		tableName="topratedmovies"
	/>
</div>
