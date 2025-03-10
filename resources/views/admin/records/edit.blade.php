@extends('layouts.app')

@section('title', 'Edit Record')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg">
    <h1 class="text-2xl mb-4">Edit Record</h1>

    <form action="{{ route('records.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block text-sm font-medium">Title</label>
        <input type="text" name="title" value="{{ $record->title }}" class="w-full border p-2 rounded mb-4">

        <label class="block text-sm font-medium">Related Documents</label>
        <input type="text" name="documents" value="{{ $record->documents }}" class="w-full border p-2 rounded mb-4">

        <label class="block text-sm font-medium">Period Covered</label>
        <div class="flex space-x-4 mb-4">
            <input type="date" name="start_date" value="{{ $record->start_date }}" class="border p-2 rounded">
            <input type="date" name="end_date" value="{{ $record->end_date }}" class="border p-2 rounded">
        </div>

        <label class="block text-sm font-medium">Volume</label>
        <input type="text" name="volume" value="{{ $record->volume }}" class="w-full border p-2 rounded mb-4">

        <div class="flex justify-end">
            <a href="{{ route('records.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Changes</button>
        </div>
    </form>
</div>

@endsection
