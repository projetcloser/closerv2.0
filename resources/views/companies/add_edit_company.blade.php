<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Form</title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

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

<div class="form-container">
    <h2>Formulaire d'Entreprise</h2>
    <form action="{{ url('/companies/add-edit-company') }}" method="POST">@csrf
        <div class="form-group">
            <label for="company_name">Nom Entreprise <span class="required">*</span></label>
            <input type="text" id="company_name" name="company_name" required>
        </div>
        <div class="form-group">
            <label for="author">Auteur <span class="required">*</span></label>
            <input type="text" id="author" name="author" value="MONGO SALOMON" readonly>
        </div>
        <div class="form-group">
            <label for="company_type">Type d'entreprise <span class="required">*</span></label>
            <select id="company_type" name="company_type" required>
                <option value="private">Privée</option>
                <option value="public">Prublique</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="tel">Tel <span class="required">*</span></label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="contact_person">Personne à contacter <span class="required">*</span></label>
            <input type="text" id="contact_person" name="contact_person" required>
        </div>
        <div class="form-group">
            <label for="contact_person_phone">Tel contact</label>
            <input type="tel" id="contact_person_phone" name="contact_person_phone">
        </div>
        <div class="form-group">
            <label for="nui">NUI <span class="required">*</span></label>
            <input type="text" id="nui" name="nui" required>
        </div>
        <div class="form-group">
            <label for="country">Pays<span class="required">*</span></label>
            <input type="hidden" name="country" value="1" >
            <input type="text" value="Cameroun" readonly>
        </div>
        <div class="form-group">
            <label for="city">Ville<span class="required">*</span></label>
            <input type="text" id="city">
            {{ csrf_field() }}
            <select id="city_select" name="city_select" style="display: none;" required>
                <!-- Options will be populated here by jQuery -->
            </select>
        </div>
        <div class="form-group">
            <label for="neighborhood">Quartier</label>
            <input type="text" id="neighborhood" name="neighborhood">
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

</body>

<script type="text/javascript">
$(document).ready(function(){
    $('#city').keyup(function(){
        var query = $(this).val();
        if(query != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('companies.ajax-autocomplete-search-city') }}",
                method: "POST",
                dataType: 'json',
                delay: 200,
                data:{query:query, _token:_token},
                success:function(data){
                    var options = '';
                    data.forEach(function(city) {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                    $('#city_select').html(options);
                    $('#city_select').show();  // Show the select element if it was hidden
                },
                cache: true
            });
        };
    });
});
</script>


</html>
