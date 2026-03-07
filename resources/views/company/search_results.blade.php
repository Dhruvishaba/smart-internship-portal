<form action="{{ route('company.search') }}" method="GET" 
      style="display:flex;gap:10px;">

    <input type="text" 
           name="keyword"
           placeholder="Search by skill or location..."
           value="{{ request('keyword') }}"
           style="flex:1;padding:12px;border-radius:6px;border:1px solid #ccc;">

    <button type="submit"
            style="background:#007bff;color:white;
                   padding:10px 20px;border:none;border-radius:6px;">
        Search
    </button>

</form>