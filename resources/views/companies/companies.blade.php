<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Entreprises</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container .form-group {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
        }
        .form-container input,
        .form-container select {
            width: calc(100% - 10px);
            padding: 8px 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-container .form-group.inline {
            display: flex;
            justify-content: space-between;
        }
        .form-container .form-group.inline .form-group-inner {
            width: 48%;
        }
        .form-container .required {
            color: red;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Liste des Entreprises</h2>
    <div>
        <a href="{{ url('/companies/add-edit-company') }}" style="max-width:200px; float: right; display: inline-block" class="btn btn-outline-success  mr-2">Ajouter un entreprise</a>
    </div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Nom Entreprise</th>
                <th>Auteur</th>
                <th>Type d'entreprise</th>
                <th>Email</th>
                <th>Tel</th>
                <th>Personne à contacter</th>
                <th>Tel contact</th>
                <th>NUI</th>
                <th>Quartier</th>
                <th>Ville</th>
                <th>Pays</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->social_reason }}</td>
                    <td>{{ $company->author }}</td>
                    <td>{{ $company->type }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->contact_person }}</td>
                    <td>{{ $company->contact_person_phone }}</td>
                    <td>{{ $company->nui }}</td>
                    <td>{{ $company->neighborhood }}</td>
                    <td>{{ $company->city->name }}</td>
                    <td>{{ $company->country->name }}</td>
                    <td>{{ $company->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
