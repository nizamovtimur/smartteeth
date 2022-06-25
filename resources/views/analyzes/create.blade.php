@extends('layouts.app')

@section('content')
    <div class="container-fluid content">
        <h1 class="m-3 f-">Загрузка фото для анализа</h1>
        <div>
            <form action="{{ route('analyzes.store') }}"  method="POST" enctype="multipart/form-data">

                <div class="form-group m-3">
                    <strong>Изображение:</strong>
                    <input type="file" name="image" class="form-control" accept="image/*,image/jpeg">
                </div>

                <div class="form-group m-3">
                    <strong>Пациент:</strong>
                    <select name="patient_id" class="form-select" aria-label="Выбор пациента" required>
                        <option selected disabled value="">Выберите пациента...</option>
                        @foreach(\App\Models\Patient::all() as $patient)
                            <option value="{{$patient->id}}">{{$patient->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-info m-3">Анализировать</button>

            </form>
        </div>
        <div id="feedback">

        </div>
    </div>
@endsection