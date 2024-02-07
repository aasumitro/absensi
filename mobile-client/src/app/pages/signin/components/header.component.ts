import {Component} from "@angular/core";

@Component({
  selector: 'app-signin-header',
  template: `
    <section class="heading ion-margin-top">
      Hey, hello 👋
    </section>
    <section class="subheading ion-margin-top">
      One step closer to continue!
    </section>
  `,
  styles: [`
    .heading {
      font-size: 24px;
      font-weight: 700;
      line-height: 29px;
      color: var(--ion-color-main-text-dark);
    }
    .subheading {
      font-size: 16px;
      font-weight: 500;
      color: var(--ion-color-main-text);
      margin-bottom: 21px;
    }
  `],
  standalone: true,
})
export class HeaderComponent {}
