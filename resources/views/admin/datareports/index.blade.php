@extends('layouts.app')
@section('content')

<div class="relative bg-white p-6 rounded-lg shadow-md">

    {{-- Include Data NavBar --}}
    @include('datanavbar')

    <!-- Hive Heading -->
    <h3 class='mx-2 font-bold py-1 text-green-600'>
        Hive : <span class="font-extrabold">{{ $hive_id ?? '' }}</span>
    </h3>

    <!-- Month and Year Selection -->
    <h3 class='mx-2 font-bold py-1 text-green-600'>Select a Month & Year</h3>

    <div class="flex items-center space-x-4 mb-4">
        <!-- Month Dropdown -->
        <div class="relative w-32">
            <select id="month" class="block appearance-none w-full bg-white border-2 border-green-800 rounded-lg py-2 pl-3 pr-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}">{{ $m }}</option>
                @endfor
            </select>
        </div>

        <!-- Year Dropdown -->
        <div class="relative w-32">
            <select id="year" class="block appearance-none w-full bg-white border-2 border-green-800 rounded-lg py-2 pl-3 pr-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500">
                @foreach ([2022, 2023, 2024, 2025] as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <!-- Generate Report Button -->
        <button id="downloadBtn" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300 text-center flex items-center justify-center space-x-1">
            <span class="mr-1">Generate Report</span>
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Optional Chart Section (Empty Placeholder) -->
    <div id="chart" style="width: 100%; height: 600px;"></div>
    
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('downloadBtn').addEventListener('click', function () {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const hiveId = "{{ $hive_id ?? '' }}";

        const originalHtml = this.innerHTML;
        this.innerHTML = '<span>Generating Report...</span>';
        this.disabled = true;

        fetch('/generate-local-report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                month: month,
                year: year,
                hive_id: hiveId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to generate report');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.download_url) {
                const a = document.createElement('a');
                a.href = data.download_url;
                a.download = `hive_report_${hiveId}_${month}_${year}.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            this.innerHTML = originalHtml;
            this.disabled = false;
        });
    });
</script>
@endsection
