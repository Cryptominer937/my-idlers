@section('title', 'YABS results')
<x-app-layout>
    <x-slot name="header">
        {{ __('YABS') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <x-card class="shadow mt-3">
            <a href="{{ route('yabs.compare-choose') }}" class="btn btn-success mb-3">Compare YABS</a>
            <x-response-alerts></x-response-alerts>
            <div class="table-responsive">
                <table class="table table-bordered" id="labels-table">
                    <thead class="table-light">
                    <tr class="bg-gray-100">
                        <th class="text-center">Server</th>
                        <th class="text-center">CPU</th>
                        <th class="text-center">CPU FREQ</th>
                        <th class="text-center">RAM</th>
                        <th class="text-center">Disk</th>
                        <th class="text-center">GB5 S</th>
                        <th class="text-center">GB5 M</th>
                        <th class="text-center">GB6 S</th>
                        <th class="text-center">GB6 M</th>
                        <th class="text-center">IPv6</th>
                        <th class="text-center">4k</th>
                        <th class="text-center">64k</th>
                        <th class="text-center">512k</th>
                        <th class="text-center">1m</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($yabs))
                        @foreach($yabs as $yab)
                            <tr>
                                <td><a href="servers/{{$yab->server_id}}"
                                       class="text-decoration-none">{{ $yab->server->hostname }}</a></td>
                                <td><span title="{{$yab->cpu_model}}">{{ $yab->cpu_cores }}</span></td>
                                <td><span title="{{$yab->cpu_model}}">{{ bcdiv($yab->cpu_freq, 1, 0); }}<small>Mhz</small></span></td>
                                <td>{{ bcdiv($yab->ram, 1, 2); }}<small>{{ $yab->ram_type }}</small></td>
                                <td>{{ bcdiv($yab->disk, 1, 2); }}<small>{{ $yab->disk_type }}</small></td>
                                <td><a href="https://browser.geekbench.com/v5/cpu/{{$yab->gb5_id}}"
                                       class="text-decoration-none">{{ $yab->gb5_single }}</a></td>
                                <td><a href="https://browser.geekbench.com/v5/cpu/{{$yab->gb5_id}}"
                                       class="text-decoration-none">{{ $yab->gb5_multi }}</a></td>
                                <td><a href="https://browser.geekbench.com/v6/cpu/{{$yab->gb6_id}}"
                                       class="text-decoration-none">{{ $yab->gb6_single }}</a></td>
                                <td><a href="https://browser.geekbench.com/v6/cpu/{{$yab->gb6_id}}"
                                       class="text-decoration-none">{{ $yab->gb6_multi }}</a></td>
                                <td>@if($yab->has_ipv6 === 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>{{ bcdiv($yab->disk_speed->d_4k, 1, 2); }}<small>{{ $yab->disk_speed->d_4k_type }}</small></td>
                                <td>{{ bcdiv($yab->disk_speed->d_64k, 1, 2); }}<small>{{ $yab->disk_speed->d_64k_type }}</small></td>
                                <td>{{ bcdiv($yab->disk_speed->d_512k, 1, 2); }}<small>{{ $yab->disk_speed->d_512k_type }}</small>
                                </td>
                                <td>{{ bcdiv($yab->disk_speed->d_1m, 1, 2); }}<small>{{ $yab->disk_speed->d_1m_type }}</small></td>
                                <td class="text-nowrap">{{ date_format(new DateTime($yab->output_date), 'Y-m-d') }}</small></td>
                                <td class="text-nowrap">
                                    <form action="{{ route('yabs.destroy', $yab->id) }}" method="POST">
                                        <a href="{{ route('yabs.show', $yab->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-eye" title="view"></i>
                                        </a>

                                        <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                           id="{{$yab->id}}" title="{{$yab->server->hostname}}"></i>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No YABS found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </div>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
    
        <script>
            window.addEventListener('load', function () {
                $('#labels-table').DataTable({
                    "pageLength": 15,
                    "lengthMenu": [5, 10, 15, 25, 30, 50, 75, 100],
                    "columnDefs": [
                        {"orderable": false, "targets": 1}
                    ],
                    "initComplete": function () {
                        $('.dataTables_length,.dataTables_filter').addClass('mb-2');
                        $('.dataTables_paginate').addClass('mt-2');
                        $('.dataTables_info').addClass('mt-2 text-muted ');
                    }
                });
            })
        </script>
    <x-modal-delete-script>
        <x-slot name="uri">yabs</x-slot>
    </x-modal-delete-script>
</x-app-layout>
