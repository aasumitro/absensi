import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: 'preload',
    loadComponent: () => import('./pages/preload/preload.page').then((m) => m.PreloadPage),
  },
  {
    path: 'signin',
    loadComponent: () => import('./pages/signin/signin.page').then((m) => m.SigninPage),
  },
  {
    path: 'home',
    loadComponent: () => import('./pages/home/home.page').then((m) => m.HomePage),
  },
  {
    path: '',
    redirectTo: 'preload',
    pathMatch: 'full',
  },
];
