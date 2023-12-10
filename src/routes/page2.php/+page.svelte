<script>
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import Nombre from '../components/Nombre.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
</script>

<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar">
	<PageSwitcher page={2} />

	<Nombre
		sql="SELECT sum(votecount) as _count FROM 'topratedmovies';
		"
		sectionTitle="Le nombre total de vote dans la table topratedmovies"
	/>

	<br />

	<Nombre
		sql="SELECT count(*) as _count FROM bestshowsnetflix where SEASONS > 5
		"
		sectionTitle="Le nombre de série qui ont plus de 5 saisons"
	/>
	<br />

	<Nombre
		sql="SELECT avg(DURATION) as _count FROM bestmoviesnetflix where DURATION >= (select DURATION from bestmoviesnetflix where TITLE = 'Steve Jobs');
		"
		sectionTitle="La durée moyenne des films qui durent plus longtemps que le film 'Steve Jobs'"
		roundResult={false}
	/>

	<br />

	<Resume
		sql="SELECT * from topratedmovies where Title like '%Die Hard%' order by Popularity LIMIT 1 OFFSET 2;"
		sectionTitle="La description du film à la popularité médiane Die Hard"
		tableName="topratedmovies"
	/>
</div>
