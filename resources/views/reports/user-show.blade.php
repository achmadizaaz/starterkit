<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengguna</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-size: 12px;
            font-family: "Poppins", sans-serif;
            margin: 0
        }

        .container{
            position: relative;
            width: 1200px;
            margin: 0 auto;
        }

        .navbar {
            background: #dddcdc;
            height: 80px;
            margin-bottom: 10px;
        }

        .navbar .title {
            position: absolute;
            font-size: 24px;
            font-weight: 500;
            top:18px;
        }

        .navbar .back {
            position: absolute;
            right: 110px;
            top: 20px;
            padding: 10px 15px;
        }

        .navbar .btn-back {
            background: #4c4d4c;
            background-image: -webkit-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -moz-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -ms-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -o-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: linear-gradient(to bottom, #4c4d4c, #2b2d2b);
            -webkit-border-radius: 13;
            -moz-border-radius: 13;
            border-radius: 13px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .navbar .print {
            position: absolute;
            right: 0;
            top: 20px;
            padding: 10px 15px;
        }
        .navbar .btn-print {
            background: #0b651f;
            background-image: -webkit-linear-gradient(top, #27de4e, #35c441);
            background-image: -moz-linear-gradient(top, #27de4e, #35c441);
            background-image: -ms-linear-gradient(top, #27de4e, #35c441);
            background-image: -o-linear-gradient(top, #27de4e, #35c441);
            background-image: linear-gradient(to bottom, #27de4e, #35c441);
            -webkit-border-radius: 13;
            -moz-border-radius: 13;
            border-radius: 13px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .navbar a.btn-print {
            text-color:#fff;
            text-decoration: none;
        }

        .navbar .btn-print:hover {
            background: #3cfc76;
            background-image: -webkit-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -moz-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -ms-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -o-linear-gradient(top, #3cfc76, #1ad251);
            background-image: linear-gradient(to bottom, #3cfc76, #1ad251);
            text-decoration: none;
        }
        .header {
            position: relative;
            width: 1200px;
            height: 60px;
            padding: 30px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid #cecece;
        }
        .logo {
            position: absolute;
            top:10px;
            left:0;

        }
        .header-body {
            float: left;
            width: 100%;
            text-align: center;
            line-height: 1.6em;

        }

        .header-title {
            font-size: 22px;
            font-weight: 600;
        }

        .headline {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .flex-info {
            display: flex;
            flex-wrap: wrap;
            font-size: 12px;
        }
        .flex-info td:first-child{
            width: 100px;
        }
        .flex-info-left {
            flex: 50%;
            text-align: left;
        }
        .flex-info-right {
            flex: 50%;
            text-align: left;
        }
        table.table-data {
            border-collapse: collapse;
        }
        .table-data{
            width: 100%;
        }
        .table-data th {
            text-align: left;
            padding:4px 8px;
        }
        .table-data td {
            text-align: left;
            padding:4px 8px;
        }
        .thead-data {
            display: none
        }

        .footer {
            text-align: right;
            margin-top:30px;
            padding: 10px 0;
        }

        @media print {
            body {
                margin: 0.1cm 0.1cm 0.1cm 0.1cm;
            }

            #navbar {
                display: none;

            }
            .header {
                width: 100%
            }
            
            .header-body{
                font-size:11px;
            }

            .container {
                width:100%;
                margin-top: 10px;
            }

        }


    </style>
</head>
<body>

    <div class="navbar" id="navbar">
        <div class="container">
            <div class="title">
                User Report
            </div>
            <div class="back">
                <a href="{{ route('report.users') }}" class="btn-back">
                    Back
                </a>
            </div>
            <div class="print">
                <a href="#print" class="btn-print" onclick="window.print()">
                    Print Page
                </a>
            </div>
        </div>
    </div>

    @php
        $option = \App\Models\Option::whereIn('name', ['favicon', 'site-title', 'address', 'contact'])->get()->keyBy('name'); 
    @endphp

    <div class="container">
        <!-- Start Header Report -->
        <div class="header" id="header">
            <div class="logo">
                <img src="{{ asset('storage/'.$option['favicon']->value ?? 'assets/images/laravel.png') }}" alt="logo-sm" width="94" height="98">
            </div>
            <div class="header-body">
                <div class="header-title" style="margin-bottom:5px">
                    {{ $option['site-title']->value }}
                </div>
                <div class="header-address">
                    {{ $option['address']->value }}
                </div>
                <div class="header-contact">
                    {{ $option['contact']->value }}
                </div>
            </div>
        </div>
        <!-- End Header Report -->
        <br>

        <div class="headline">
            User Report
        </div>

        <!-- Start Info -->
        <div class="flex-info">
            <div class="flex-info-left">
               <table>
                    <tr>
                        <td style="width: 100px">Status</td>
                        <td>:</td>
                        <td>{{ ucwords($isActive) }}</td>
                    </tr>
                    <tr>
                        <td >Role</td>
                        <td>:</td>
                        <td>{{ ucwords($role) }}</td>
                    </tr>
               </table>
            </div>
            <div class="flex-info-right">
                <table>
                    <tr>
                        <td>Order by</td>
                        <td>:</td>
                        <td>
                            {{ ucwords($orderBy) }}
                        </td>
                    </tr>
               </table>
            </div>
        </div>
        <!-- End Info -->
        <br>

        <!-- Start Data User -->
        <table border="1" class="table-data">
            <thead>
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Last login at</th>
                <th>Last login ip</th>
            </thead>
            <tbody>
                @if ($users->count() == 0)
                    <tr>
                        <td colspan="8" style="background: #fff8a8;text-align:center">Data not available.</td>
                    </tr>
                @endif
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_active ? 'Active' : 'Non active'; }}</td>
                        <td>
                            @if ($role == 'semua')
                                    {{ count($user->roles->pluck('name')) > 0 ? str_replace('"', ' ',trim($user->roles->pluck('name'), '[]')) : '-'  }}
                                @else
                                    {{ $role }}
                            @endif
                        </td>
                        <td>{{ $user->last_login_at ?? '-' }}</td>
                        <td>{{ $user->last_login_ip ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Data User -->
        {{-- \Carbon\Carbon::now()->translatedFormat --}}
        <div class="footer">
            <div class="foot-date">
                {{ now()->translatedFormat('d F Y') }}
            </div>
            <div class="foot-name">
                {{ $option['site-title']->value }}
            </div>
        </div>
    </div> <!-- End Container   -->

</body>
</html>