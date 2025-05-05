@extends('layouts.main')

@section('title', 'Foundation')

@section('content')
    <x-page-title />

    <x-page-section class="services section light-background" section="Services">

        <div class="row g-4">
            {{-- Manual Assessment Card --}}
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card d-flex">
                    <div class="icon flex-shrink-0">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div>
                        <h3>Create Assessment Manually</h3>
                        <p>
                            Design custom assessments tailored to your needs by manually adding questions, setting
                            difficulty levels, assigning scores, and defining correct answers. This method gives you full
                            control over every detail of the assessment structure.
                        </p>
                        <a href="#" class="btn btn-primary">
                            Go to create <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- AI Assessment Card --}}
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="position-relative">
                    <span class="badge rounded-pill text-bg-warning px-2 py-3 fs-6 fw-semibold position-absolute"
                        style="top: -25px; left: -10px;">
                        Coming Soon.....
                    </span>
                    <div class="service-card d-flex">
                        <div class="icon flex-shrink-0">
                            <i class="bi bi-activity"></i>
                        </div>
                        <div>
                            <h3>Generate Assessment Using AI</h3>
                            <p>
                                Quickly create intelligent assessments using AI-driven generation. Just provide basic input
                                or topics, and let the system auto-generate relevant questions and answer options — saving
                                you time while maintaining quality.
                            </p>
                            <a href="#" class="btn btn-primary disabled">
                                Go to generate <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-page-section>
@endsection
