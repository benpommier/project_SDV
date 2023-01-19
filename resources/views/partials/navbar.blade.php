<div class="topnav" id="myTopnav">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('annonces') }}">Les annonces</a>
    <a href="{{ route('jerome') }}">jeje</a>
    <div class="subnav">
        <button class="subnavbtn"> Inscription / Connexion <i class="fa fa-caret-down"></i></button>
        <div class="subnav-content">
            <a href="{{ route('connexion') }}">Connexion</a>
            <a href="#inscription">Inscription</a>
        </div>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>