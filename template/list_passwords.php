{% extends "base.php" %}

{% block title %}Mots de passe{% endblock %}

{% block content %}

<script src="{{ '../js/security.js' }}"></script>

{% if session.session_id is null %}
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <p class="alert alert-warning"> vous n'êtes pas connecté </p>
    </div>
</div>
{% else %}
<div class="row">
    <h2 class="col-sm-2 col-sm-offset-5">Mots de passe</h2>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        {% if passwords is defined %}
        {% for p in passwords %}
        <h1> {{ p.label }} </h1>

        <button onclick="decodePassword('{{p.password}}')">  {{ p.login }} </button>
        {% endfor %}
        {% endif %}
    </div>
</div>
{% endif %}
{% endblock %}