@extends('layout.layout')

@section('content')

<div class="doc-content">
    <header>
        <p id="greetings">Documents</p>
    </header>

    <div class="docu-rows">

        <div class="docu-col1">

            <div class="docu-tile1">
                <h2>Property / Lease</h2>
                <button id="docu-button" onclick="openPDF('property_lease')">
                    Preview / Download
                </button>
            </div>

            <div class="docu-tile2" id=docu-tile22>
                <h2>Certificate of Occupancy</h2>
                <button id="docu-button" onclick="openPDF('certificate')">
                    Preview / Download
                </button>
            </div>

        </div>

        <div class="docu-col2">

            <div class="docu-tile1">
                <h2>Deed of Sale</h2>
                <button id="docu-button" onclick="openPDF('deed')">
                    Preview / Download
                </button>
            </div>

            <div class="docu-tile2" id=docu-tile22>
                <h2>Ticket History</h2>
                <button id="docu-button" onclick="openPDF('ticket')">
                    Preview / Download
                </button>
            </div>

        </div>

    </div>
</div>

<script>
function openPDF(type) {
    fetch(`/check-file/${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                // Open PDF in a new tab
                window.open(`/download/${type}`, '_blank');
            } else {
                // No new tab — just show message
                alert('This file is not yet available. Contact an administrator for assistance.');
            }
        })
        .catch(() => {
            alert('Error checking the document.');
        });
}
</script>

@endsection
