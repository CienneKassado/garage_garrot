# appJO/views.py
from django.shortcuts import render
from django.views import View


def accueil(request):
    return render(request, 'accueil.html')


