import {Component, EventEmitter, Output} from "@angular/core";
import {IonButton, IonInput, IonItem, IonLabel} from "@ionic/angular/standalone";
import {FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators} from "@angular/forms";

@Component({
  selector: 'app-signin-grant-access',
  template: `
    <section class="section-input-email">
      <form
        class="form-validate"
        action="#"
        method="post"
        [formGroup]="form"
        novalidate
      >
        <ion-item>
          <ion-label label="Username" position="stacked">
            Nama Pengguna
          </ion-label>
          <ion-input
            aria-label="Username"
            formControlName="userInput"
            placeholder="e.g: ungkeindesekay"
          ></ion-input>
        </ion-item>
      </form>
      <div class="section-action">
        <ion-button
          [disabled]="!form.valid"
          (click)="performGrantAccess()"
        >Lanjutkan</ion-button>
      </div>
    </section>
  `,
  styles: [`
    .section-input-email {
      @media(min-width: 768px) { width: 368px; }
      ion-item {
        --highlight-color-focused: var(--ion-color-main-text) !important;
        --highlight-color-valid: var(--ion-color-main-text) !important;
        --highlight-color-invalid: var(--ion-color-main-text)  !important;
        pointer-events: auto !important;
        ion-label {
          font-size: 16px;
          font-weight: 500;
          line-height: 20px;
          color: var(--ion-color-main-text);
          margin-bottom: 10px;
        }
        ion-input {
          --padding-top: 15px !important;
          --padding-bottom: 15px !important;
          --placeholder-color: rgba(var(--ion-color-main-text-dark-2-rgb),.6);
        }
      }
    }
    .section-action {
      @media(min-width: 768px) {
        position: relative;
        margin: auto;
        width: 368px;
      }
      position: static;
      padding: 0 0 15px 0 !important;
      background-color: transparent !important;
      justify-content: space-between;
      ion-button {
        margin-top: 20px;
        --border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        line-height: 18px;
        min-height: 50px;
        &:first-child { width: 100%; }
        &.scan { margin-left: 10px; width: 55px; }
      }
    }
  `],
  standalone: true,
  imports: [
    FormsModule,
    ReactiveFormsModule,
    IonItem,
    IonLabel,
    IonInput,
    IonButton,
  ],
})
export class GrantAccessComponent {
  @Output() grantAccessEvent = new EventEmitter<string>();

  form: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
  ) {
    this.form = this.formBuilder.group({
      userInput: ['', [Validators.required]],
    });
  }

  performGrantAccess = async () => this.grantAccessEvent.emit();
}
