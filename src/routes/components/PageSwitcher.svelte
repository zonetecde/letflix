<script lang="ts">
	export let page: Number = 1;

	function handleNextPage() {
		if (page == 4) {
			return;
		} else window.location.href = '/page' + (Number(page) + 1) + '.php';
	}

	function handlePreviousPage() {
		if (page == 1) {
			return;
		} else window.location.href = '/page' + (Number(page) - 1) + '.php';
	}
</script>

<div class="flex w-full flex-row mb-3">
	<button
		class={'h-14 -mt-1 ' + (page == 1 ? 'cursor-not-allowed' : 'cursor-pointer')}
		on:click={handlePreviousPage}
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			fill="none"
			viewBox="0 0 24 24"
			stroke-width="1.5"
			stroke={page == 1 ? 'gray' : 'white'}
			class="h-14"
		>
			<path
				stroke-linecap="round"
				stroke-linejoin="round"
				d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
			/>
		</svg>
	</button>

	<h1 class="text-4xl font-bold underline underline-offset-4 text-white ml-auto">
		Fiche {page}
	</h1>

	<button
		class={'h-14 -mt-1 ml-auto ' + (page == 5 ? 'cursor-not-allowed' : 'cursor-pointer')}
		on:click={handleNextPage}
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			fill="none"
			viewBox="0 0 24 24"
			stroke-width="1.5"
			stroke={page == 4 ? 'gray' : 'white'}
			class="h-14"
		>
			<path
				stroke-linecap="round"
				stroke-linejoin="round"
				d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
			/>
		</svg>
	</button>
</div>
