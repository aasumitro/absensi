import {Component, EventEmitter, Output} from "@angular/core";
import {IonInput, IonItem, IonList} from "@ionic/angular/standalone";
import {FormsModule} from "@angular/forms";
import {isEmpty} from "../../../utils/validation";

@Component({
  selector: 'app-signin-verify-access',
  template: `
    <section class="section-input-code">
      <ion-list>
        <p>Kode Verifikasi</p>
        <ion-item>
          <ion-input
            [(ngModel)]="code1"
            type="tel"
            #c1
            (keyup)="verificationCodeController($event, 'code1', c2, '')"
            (input)="verificationCodeController($event, 'code1', c2, '')"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code2"
            type="tel"
            #c2
            (keyup)="verificationCodeController($event, 'code2', c3, c1)"
            (input)="verificationCodeController($event, 'code2', c3, c1)"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code3"
            type="tel"
            #c3
            (keyup)="verificationCodeController($event, 'code3', c4, c2)"
            (input)="verificationCodeController($event, 'code3', c4, c2)"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code4"
            type="tel"
            #c4
            (keyup)="verificationCodeController($event, 'code4', c5, c3)"
            (input)="verificationCodeController($event, 'code4', c5, c3)"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code5"
            type="tel"
            #c5
            (keyup)="verificationCodeController($event, 'code5', c6, c4)"
            (input)="verificationCodeController($event, 'code5', c6, c4)"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code6"
            type="tel"
            #c6
            (keyup)="verificationCodeController($event, 'code6', c7, c5)"
            (input)="verificationCodeController($event, 'code6', c7, c5)"
          ></ion-input><!-- add class="error" if code not match -->
          <ion-input
            [(ngModel)]="code7"
            type="tel"
            #c7
            (keyup)="verificationCodeController($event, 'code7', '', c6)"
            (input)="verificationCodeController($event, 'code7', '', c6)"
          ></ion-input><!-- add class="error" if code not match -->
        </ion-item>
      </ion-list>
      <div class="desc">
        <div class="ask">
          Tidak menerima kode verifikasi?
        </div>
        <button class="action" (click)="performResendVerificationCode()">
          Kirim ulang
        </button>
      </div>
    </section>
  `,
  styles: [`
    .section-input-code {
      @media(min-width: 768px) { width: 368px; }
      ion-list {
        margin: 0;
        p {
          margin-bottom: 0;
          font-size: 16px;
          font-weight: 500;
          line-height: 20px;
          color: var(--ion-color-main-text);
        }
      }
      ion-item {
        margin: 10px -2.5px;
        --highlight-color-focused: transparent !important;
        --highlight-color-valid: transparent !important;
        --highlight-color-invalid: transparent  !important;
        ion-input {
          margin: 0 auto;
          --placeholder-color: rgba(var(--ion-color-main-text-dark-2-rgb),.6);
          text-align: center;
          height: 65px;
          width: 45px;
          --padding-top: 5px !important;
          --padding-bottom: 5px !important;
          --padding-start: 5px !important;
          --padding-end: 5px !important;
          font-weight: 600;
          font-size: 30px !important;
          color: var(--ion-color-main-text-dark);
          input { height: 65px; }
          &.error { color: var(--ion-color-danger); border: 1px solid var(--ion-color-danger);}
        }
        &.failed {
          position: relative;
          color: var(--ion-color-red);
          ion-label { color: var(--ion-color-red);}
          ion-input {
            border: 1px solid var(--ion-color-red);
            --placeholder-color: var(--ion-color-red);
            &.has-focus { border-bottom: 1px solid var(--ion-color-red); }
            &.has-value { color: var(--ion-color-red); border-bottom: 1px solid var(--ion-color-red);}
          }
        }
      }
    }
    .desc {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 400;
      margin-top: 10px;
      color: var(--ion-color-main-text-dark);
      .ask { padding-right: 5px; color: var(--ion-color-main-text); }
      .action { font-weight: 600; color: var(--ion-color-main-text-dark); text-decoration: underline; }
    }
  `],
  standalone: true,
  imports: [
    FormsModule,
    IonItem,
    IonInput,
    IonList
  ],
})
export class VerifyAccessComponent {
  @Output() verifyAccessEvent = new EventEmitter<string>();

  code1: string = '';
  code2: string = '';
  code3: string = '';
  code4: string = '';
  code5: string = '';
  code6: string = '';
  code7: string = '';

  constructor() {}

  verificationCodeController = async (
    event: any, field: any,
    next: any, prev: any,
  ) => {
    // @ts-ignore
    this[field] = event.target.value;
    if (event.target.value.length === 7) {
      const otpCode = event.target.value;
      const codeSplit = otpCode.split('');
      this.code1 = codeSplit[0];
      this.code2 = codeSplit[1];
      this.code3 = codeSplit[2];
      this.code4 = codeSplit[3];
      this.code5 = codeSplit[4];
      this.code6 = codeSplit[5];
      this.code7 = codeSplit[6];
      await this.performSubmitVerificationCode();
    } else if (event.target.value.length > 1) {
      event.preventDefault();
    } else if (event.keyCode === 8 && event.target.value.length < 1 && prev) {
      prev.setFocus();
    } else if (next && event.target.value.length > 0) {
      next.setFocus();
    } else if (isEmpty(next)) {
      await this.performSubmitVerificationCode();
    }
  }

  validInputValue = () => (
    !isEmpty(this.code1) && !isEmpty(this.code2) &&
    !isEmpty(this.code3) && !isEmpty(this.code4) &&
    !isEmpty(this.code5) && !isEmpty(this.code6) &&
    !isEmpty(this.code7)
  )

  performSubmitVerificationCode = async () => {
    if (this.validInputValue()) {
      if (this.combineInputValue() === '1234567') {
        this.verifyAccessEvent.emit("THIS_CURRENT_ACCESS_TOKEN")
      }
    }
  }

  performResendVerificationCode = () => console.log("Resend verification code")

  combineInputValue = (): string => (
    `${this.code1}${this.code2}${this.code3}` +
    `${this.code4}${this.code5}${this.code6}` +
    `${this.code7}`
  )
}
