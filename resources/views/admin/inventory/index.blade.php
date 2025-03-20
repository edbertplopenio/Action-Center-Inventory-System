@extends('layouts.app')

@section('title', 'Equipment Management') <!-- Optionally set the page title -->

@section('content')
    <h1 class="text-xl font-bold">ADMINNNN</p>

    <!-- Your specific page content goes here -->
    <!-- Example Table or List -->
    <div class="mt-5">
        <table class="min-w-full border-collapse table-auto">
            <thead>
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Equipment Name</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">1</td>
                    <td class="border p-2">Laptop</td>
                    <td class="border p-2"><button>Edit</button></td>
                </tr>
                <!-- More rows here -->
            </tbody>
        </table>
    </div>
@endsection