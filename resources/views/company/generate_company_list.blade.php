<select class="form-control" name="company_id">
    @foreach($companies as $company)
        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
    @endforeach
</select>