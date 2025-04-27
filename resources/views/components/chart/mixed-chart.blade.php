<div class="bg-white rounded-xl shadow-md p-6 w-full my-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <h2 class="text-xl md:text-2xl font-semibold text-slate-700">Data Total Penduduk Tahun 2025</h2>
        <div class="flex items-center gap-3">
            <select id="filterKelamin"
                class="border border-slate-300 text-sm rounded-md px-3 py-2 text-slate-600 focus:outline-none w-full md:w-auto">
                <option value="all">Semua</option>
                <option value="laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>
        </div>
    </div>

    <div id="{{ $id }}" class="w-full"></div>
</div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let allData = {
                laki: {!! json_encode($series1Data) !!},
                perempuan: {!! json_encode($series2Data) !!}
            };

            var options = {
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                },
                stroke: {
                    width: [0, 4],
                    curve: 'smooth',
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 3,
                        blur: 5,
                        opacity: 0.5,
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '40%',
                        borderRadius: 6,
                    }
                },
                colors: ['#0AB300', '#48FF3F'],

                series: [{
                        name: 'Laki-laki',
                        type: 'column',
                        data: allData.laki
                    },
                    {
                        name: 'Perempuan',
                        type: 'line',
                        data: allData.perempuan
                    }
                ],
                markers: {
                    size: 5,
                    colors: ['#16a34a'],
                    strokeColors: '#ffffff',
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                xaxis: {
                    categories: {!! json_encode($categories) !!},
                    labels: {
                        style: {
                            colors: '#94a3b8',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: [{
                        opposite: false,
                        labels: {
                            style: {
                                colors: '#94a3b8',
                            }
                        },
                    },
                    {
                        opposite: true,
                        title: {
                            text: 'Banyak Jiwa',
                            style: {
                                color: '#16a34a',
                                fontWeight: 500
                            }
                        },
                        labels: {
                            style: {
                                colors: '#16a34a',
                            }
                        }
                    }
                ],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(val) {
                            return val + " Jiwa";
                        }
                    }
                },
                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 4,
                },
            };

            var chart = new ApexCharts(document.querySelector("#{{ $id }}"), options);
            chart.render();

            document.getElementById('filterKelamin').addEventListener('change', function(e) {
                let value = e.target.value;
                if (value === 'laki') {
                    chart.updateSeries([{
                            name: 'Laki-laki',
                            type: 'column',
                            data: allData.laki
                        },
                        {
                            name: '',
                            type: 'line',
                            data: []
                        }
                    ]);
                } else if (value === 'perempuan') {
                    chart.updateSeries([{
                            name: '',
                            type: 'column',
                            data: []
                        },
                        {
                            name: 'Perempuan',
                            type: 'line',
                            data: allData.perempuan
                        }
                    ]);
                } else {
                    chart.updateSeries([{
                            name: 'Laki-laki',
                            type: 'column',
                            data: allData.laki
                        },
                        {
                            name: 'Perempuan',
                            type: 'line',
                            data: allData.perempuan
                        }
                    ]);
                }
            });
        });
    </script>
@endpush
