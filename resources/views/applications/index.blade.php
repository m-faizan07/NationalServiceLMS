@extends('layouts.admin')
@section('page-title')
    {{__('Applications')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Applications')}}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Applications')}}</h5>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('NID')}}</th>
                                <th>{{__('Mobile No')}}</th>
                                <th>{{__('DOB')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($students))
                                @foreach($students as $student)

                                    <tr>
                                        <td>
                                            <div class="font-style ">{{ optional($student->profile)->first_name ?? 'N/A' }} {{ optional($student->profile)->last_name ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style ">{{ optional($student->profile)->nid ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div class="">{{ optional($student->profile)->mobile_no ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div class="">{{ optional($student->profile)->dob ? \Carbon\Carbon::parse($student->profile->dob)->format('d F Y') : 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div class="">
                                                @if($student->profile)
                                                    {{ Utility::getDateFormated($student->profile->created_at, true) }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">{{ ucfirst($student->status) ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <div>
                                                <a href="{{route('apllication.response',[$student->id,'approved'])}}" class="btn btn-success btn-sm me-1" data-bs-toggle="tooltip" data-bs-original-title="{{__('Approve')}}">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a href="{{route('apllication.response',[$student->id,'rejected'])}}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="{{__('Reject')}}">
                                                <i class="ti ti-x"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
