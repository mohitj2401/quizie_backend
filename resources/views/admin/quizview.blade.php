@extends('admin.layouts.admin')
@section('content')
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('View Quiz') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('quiz.edit', $quiz->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Title') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ old('title') ?? $quiz->title }}" required autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Subject') }}</label>

                            <div class="col-md-8">
                                <select name="subject" class="form-control" required>
                                    <option value="">Select a subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" @if ($quiz->subject->id == $subject->id) selected @endif>{{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Duration (In Minutes)') }}</label>

                            <div class="col-md-8">
                                <input class="form-control @error('duration') is-invalid @enderror" type="number"
                                    name="duration" value="{{ old('duration') ?? $quiz->duration }}" required>

                                @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9"><img src="{{ url('storage/app/public/') . '/' . $quiz->image }}"
                                    height="250">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Description') }}</label>

                            <div class="col-md-8">
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="10"
                                    name="description"
                                    required>{{ old('description') ?? $quiz->description }} </textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Quiz') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
