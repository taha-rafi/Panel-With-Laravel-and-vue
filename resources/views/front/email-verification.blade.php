@extends('front.front_layouts')

@section('content')

    <section class="sign-up-section section_padding">
        <div class="container">
            <div class="signup-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="alert">
                            <div class="alert alert-info">
                                {!! $message !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
