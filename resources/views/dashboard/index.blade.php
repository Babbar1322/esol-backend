@extends('layouts.dashboard')
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->
            </ol>
            <h4 class="main-title mb-0">Welcome to ESOL Dashboard</h4>
        </div>
        <nav class="nav nav-icon nav-icon-lg">
            <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Share"><i class="ri-share-line"></i></a>
            <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Print"><i class="ri-printer-line"></i></a>
            <a href="#" class="nav-link" data-bs-toggle="tooltip" title="Report"><i
                    class="ri-bar-chart-2-line"></i></a>
        </nav>
    </div>

    <div class="row g-3 justify-content-center">
        <div class="col-md-6 col-xl-4">
            <div class="card card-one shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <h3 class="card-value mb-1">{{ $users }}</h3>
                            <label class="card-title fw-medium text-dark mb-1">Students</label>
                            <!-- <span class="d-block text-muted fs-11 ff-secondary lh-4">No. of clicks to ad that consist of a single impression.</span> -->
                        </div><!-- col -->
                        <div class="col-5">
                            <div id="flotChart1" class="flot-chart ht-80"></div>
                        </div><!-- col -->
                    </div><!-- row -->
                </div><!-- card-body -->
            </div><!-- card-one -->
        </div><!-- col -->
        <div class="col-md-6 col-xl-4">
            <div class="card card-one shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <h3 class="card-value mb-1">{{ $tests }}</h3>
                            <label class="card-title fw-medium text-dark mb-1">Tests</label>
                            <!-- <span class="d-block text-muted fs-11 ff-secondary lh-4">Estimated daily unique views per visitor on the ads.</span> -->
                        </div><!-- col -->
                        <div class="col-5">
                            <div id="flotChart2" class="flot-chart ht-80"></div>
                        </div><!-- col -->
                    </div><!-- row -->
                </div><!-- card-body -->
            </div><!-- card-one -->
        </div><!-- col -->
        <div class="col-md-6 col-xl-4">
            <div class="card card-one shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <h3 class="card-value mb-1">785</h3>
                            <label class="card-title fw-medium text-dark mb-1">Test Taken</label>
                            <!-- <span class="d-block text-muted fs-11 ff-secondary lh-4">Estimated total conversions on ads per impressions.</span> -->
                        </div><!-- col -->
                        <div class="col-5">
                            <div id="flotChart3" class="flot-chart ht-80"></div>
                        </div><!-- col -->
                    </div><!-- row -->
                </div><!-- card-body -->
            </div><!-- card-one -->
        </div><!-- col -->
        <div class="col-md-7 col-xl-8">
            <div class="card card-one shadow">
                <div class="card-header">
                    <h6 class="card-title">Organic Visits &amp; Conversions</h6>
                    <nav class="nav nav-icon nav-icon-sm ms-auto">
                        <a href="#" class="nav-link"><i class="ri-refresh-line"></i></a>
                        <a href="#" class="nav-link"><i class="ri-more-2-fill"></i></a>
                    </nav>
                </div><!-- card-header -->
                <div class="card-body">
                    <div id="flotChart4" class="flot-chart flot-chart-one ht-300"></div>
                </div><!-- card-body -->
            </div><!-- card-one -->
        </div><!-- col -->
        <div class="col-md-5 col-xl-4">
            <div class="card card-one shadow">
                <div class="card-header">
                    <h6 class="card-title">Analytics Performance</h6>
                    <nav class="nav nav-icon nav-icon-sm ms-auto">
                        <a href="#" class="nav-link"><i class="ri-refresh-line"></i></a>
                        <a href="#" class="nav-link"><i class="ri-more-2-fill"></i></a>
                    </nav>
                </div><!-- card-header -->
                <div class="card-body p-3">
                    <h2 class="performance-value mb-0">9.8 <small class="text-success d-flex align-items-center"><i
                                class="ri-arrow-up-line"></i> 2.8%</small></h2>
                    <label class="card-title fs-sm fw-medium">Performance Score</label>
                    <div class="progress progress-one ht-8 mt-2 mb-4">
                        <div class="progress-bar w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-success w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-orange w-5" role="progressbar" aria-valuenow="5" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-pink w-5" role="progressbar" aria-valuenow="5" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-info w-10" role="progressbar" aria-valuenow="10" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        <div class="progress-bar bg-indigo w-5" role="progressbar" aria-valuenow="5" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div><!-- progress -->
                    <table class="table table-three">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-primary"></div>
                                </td>
                                <td>Excellent</td>
                                <td>3,007</td>
                                <td>50%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-success"></div>
                                </td>
                                <td>Very Good</td>
                                <td>1,674</td>
                                <td>25%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-orange"></div>
                                </td>
                                <td>Good</td>
                                <td>125</td>
                                <td>6%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-pink"></div>
                                </td>
                                <td>Fair</td>
                                <td>98</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-info"></div>
                                </td>
                                <td>Poor</td>
                                <td>512</td>
                                <td>10%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge-dot bg-indigo"></div>
                                </td>
                                <td>Very Poor</td>
                                <td>81</td>
                                <td>4%</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- card-body -->
            </div><!-- card-one -->
        </div><!-- col -->
        <div class="col-md-6">
            <div class="card card-one shadow">
                <div class="card-header">
                    <h6 class="card-title">Acquisition</h6>
                    <nav class="nav nav-icon nav-icon-sm ms-auto">
                        <a href="#" class="nav-link"><i class="ri-refresh-line"></i></a>
                        <a href="#" class="nav-link"><i class="ri-more-2-fill"></i></a>
                    </nav>
                </div><!-- card-header -->
                <div class="card-body">
                    <p class="fs-sm mb-4">Tells you where your visitors originated from, such as search engines, social
                        networks or website referrals. <a href="#">Learn more</a></p>

                    <div class="row mb-2">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-primary"><i class="ri-line-chart-fill"></i></div>
                                <div class="ms-2">
                                    <h4 class="card-value mb-1">33.50%</h4>
                                    <span class="d-block fs-sm fw-medium">Bounce Rate</span>
                                </div>
                            </div>
                        </div><!-- col -->
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-ui-02"><i class="ri-line-chart-fill"></i></div>
                                <div class="ms-2">
                                    <h4 class="card-value mb-1">9,065</h4>
                                    <span class="d-block fs-sm fw-medium">Page Sessions</span>
                                </div>
                            </div>
                        </div><!-- col -->
                    </div><!-- row -->

                    <div id="flotChart5" class="flot-chart-two ht-150"></div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
        <div class="col-md-6">
            <div class="card card-one shadow">
                <div class="card-header">
                    <h6 class="card-title">Browser Used By Users</h6>
                    <nav class="nav nav-icon nav-icon-sm ms-auto">
                        <a href="#" class="nav-link"><i class="ri-refresh-line"></i></a>
                        <a href="#" class="nav-link"><i class="ri-more-2-fill"></i></a>
                    </nav>
                </div><!-- card-header -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-one">
                            <thead>
                                <tr>
                                    <th>Browser</th>
                                    <th>Bounce Rate</th>
                                    <th>Conversion Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-chrome-line fs-24 lh-1 me-2"></i> Google Chrome</div>
                                    </td>
                                    <td>40.95%</td>
                                    <td>19.45%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-firefox-line fs-24 lh-1 me-2"></i> Mozilla Firefox</div>
                                    </td>
                                    <td>47.58%</td>
                                    <td>19.99%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-safari-line fs-24 lh-1 me-2"></i> Apple Safari</div>
                                    </td>
                                    <td>56.50%</td>
                                    <td>11.00%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-edge-line fs-24 lh-1 me-2"></i> Microsoft Edge</div>
                                    </td>
                                    <td>59.62%</td>
                                    <td>4.69%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-opera-line fs-24 lh-1 me-2"></i> Opera</div>
                                    </td>
                                    <td>52.50%</td>
                                    <td>8.75%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center fw-medium"><i
                                                class="ri-ie-line fs-24 lh-1 me-2"></i> Internet Explorer</div>
                                    </td>
                                    <td>44.95%</td>
                                    <td>8.12%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->

    <div class="card card-one mt-3 shadow">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-four table-bordered">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th colspan="3">Acquisition</th>
                            <th colspan="3">Behavior</th>
                            <th colspan="3">Conversions</th>
                        </tr>
                        <tr>
                            <th>Source</th>
                            <th>Users</th>
                            <th>New Users</th>
                            <th>Sessions</th>
                            <th>Bounce Rate</th>
                            <th>Pages/Session</th>
                            <th>Avg. Session</th>
                            <th>Transactions</th>
                            <th>Revenue</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">Organic search</a></td>
                            <td>350</td>
                            <td>22</td>
                            <td>5,628</td>
                            <td>25.60%</td>
                            <td>1.92</td>
                            <td>00:01:05</td>
                            <td>340,103</td>
                            <td>$2.65M</td>
                            <td>4.50%</td>
                        </tr>
                        <tr>
                            <td><a href="#">Social media</a></td>
                            <td>276</td>
                            <td>18</td>
                            <td>5,100</td>
                            <td>23.66%</td>
                            <td>1.89</td>
                            <td>00:01:03</td>
                            <td>321,960</td>
                            <td>$2.51M</td>
                            <td>4.36%</td>
                        </tr>
                        <tr>
                            <td><a href="#">Referral</a></td>
                            <td>246</td>
                            <td>17</td>
                            <td>4,880</td>
                            <td>26.22%</td>
                            <td>1.78</td>
                            <td>00:01:09</td>
                            <td>302,767</td>
                            <td>$2.1M</td>
                            <td>4.34%</td>
                        </tr>
                        <tr>
                            <td><a href="#">Email</a></td>
                            <td>187</td>
                            <td>14</td>
                            <td>4,450</td>
                            <td>24.97%</td>
                            <td>1.35</td>
                            <td>00:02:07</td>
                            <td>279,300</td>
                            <td>$1.86M</td>
                            <td>3.99%</td>
                        </tr>
                        <tr>
                            <td><a href="#">Other</a></td>
                            <td>125</td>
                            <td>13</td>
                            <td>3,300</td>
                            <td>21.67%</td>
                            <td>1.14</td>
                            <td>00:02:01</td>
                            <td>240,200</td>
                            <td>$1.51M</td>
                            <td>2.84%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- card-body -->
    </div><!-- card -->
@endsection
