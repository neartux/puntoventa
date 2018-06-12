@extends('admin.layouts.app')

@section('content')

    <div class="page-content" data-ng-app="AppProduct" data-ng-controller="ProductController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title"> Home
        </h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>

        </div>

        <div class="row" data-ng-show="ctrl.showProductList">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-social-dropbox font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Dashboard</span>
                        </div>
                        <div class="actions btn-set">

                        </div>
                    </div>
                    <div class="portlet-body">





                    </div>
                </div>

            </div>
        </div>


    </div>

@endsection

@section('script-section')

    <script type="text/javascript">
        $(document).ready(function () {


        });
    </script>
@endsection