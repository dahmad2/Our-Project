<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('City of Bradford Metropolitan District Council Maps') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        {{-- Filters --}}
        <form id="filter-form" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" id="search" placeholder="Search by postcode" class="w-full p-2 border rounded">

            <select id="department-filter" class="w-full p-2 border rounded">
                <option value="">All Departments</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>

            <select id="ward-filter" class="w-full p-2 border rounded">
                <option value="">All Wards</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward }}">{{ $ward }}</option>
                @endforeach
            </select>

            <select id="status-filter" class="w-full p-2 border rounded">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="terminated">Terminated</option>
            </select>
        </form>

        <div class="bg-white shadow rounded p-6">
            <div id="map" style="height: 600px; width: 100%;"></div>
        </div>
    </div>

    <script>
        let map;
        let markers = [];
        let markerCluster;

        const allAssets = @json($assets);

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 53.795, lng: -1.759 },
                zoom: 11,
            });

            renderMarkers(allAssets);
        }

        function renderMarkers(data) {
            if (markerCluster) markerCluster.clearMarkers();
            markers.forEach(m => m.setMap(null));
            markers = [];

            data.forEach(asset => {
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(asset.latitude), lng: parseFloat(asset.longitude) },
                    title: asset.postcode,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `<strong>${asset.postcode}</strong><br>${asset.ward_name_current || ''}<br>${asset.department || ''}`,
                });

                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
            });

            markerCluster = new markerClusterer.MarkerClusterer({ map, markers });
        }

        function filterAssets() {
            const search = document.getElementById('search').value.toLowerCase();
            const department = document.getElementById('department-filter').value;
            const ward = document.getElementById('ward-filter').value;
            const status = document.getElementById('status-filter').value;

            const filtered = allAssets.filter(asset => {
                const matchPostcode = asset.postcode.toLowerCase().includes(search);
                const matchDept = department ? asset.department === department : true;
                const matchWard = ward ? asset.ward_name_current === ward : true;
                const matchStatus = status === 'active'
                    ? !asset.date_of_termination
                    : status === 'terminated'
                        ? !!asset.date_of_termination
                        : true;
                return matchPostcode && matchDept && matchWard && matchStatus;
            });

            renderMarkers(filtered);
        }

        document.getElementById('filter-form').addEventListener('input', filterAssets);

    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
</x-app-layout>
