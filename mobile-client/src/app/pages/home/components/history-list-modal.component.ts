import {Component, EventEmitter, Input, Output} from "@angular/core";
import {IonContent, IonModal} from "@ionic/angular/standalone";

@Component({
  standalone: true,
  selector: 'app-history-list-modal-component',
  template: `
    <ion-modal
      [isOpen]="open"
      [initialBreakpoint]="0.88"
      [breakpoints]="[0, 0.5, 0.88]"
      (didDismiss)="setOpen(false)"
    >
      <ng-template>
        <ion-content class="ion-padding">
          Hello World, History List
        </ion-content>
      </ng-template>
    </ion-modal>
  `,
  styles: [``],
  imports: [
    IonModal,
    IonContent
  ]
})
export class HistoryListModalComponent {
  @Input() open = false;
  @Output() callback = new EventEmitter<boolean>();

  constructor() {}

  setOpen(isOpen: boolean) {
    this.open = isOpen;
    this.callback.emit(isOpen);
  }
}
