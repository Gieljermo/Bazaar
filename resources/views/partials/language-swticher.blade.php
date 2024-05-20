<form action="{{Route('switch-language')}}" method="POST" id="languageForm">
    @csrf
    <input type="hidden" name="language" id="languageInput">
    <div class="nav-item me-2 dropdown">
        <button class="btn dropdown-toggle text-uppercase" type="button" id="languageDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            {{ app()->getLocale() == 'nl' ? 'Nederlands' : 'English' }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdownButton">
            <li><a href="#" class="dropdown-item" onclick="setLanguage('nl')">Nederlands</a></li>
            <li><a href="#" class="dropdown-item" onclick="setLanguage('en')">English</a></li>
        </ul>
    </div>
</form>

<script>
    function setLanguage(language) {
        document.getElementById('languageInput').value = language;
        document.getElementById('languageForm').submit();
    }
</script>