import {
  Component, ElementRef, EventEmitter, OnInit,
  Output, QueryList, ViewChild, ViewChildren,
} from "@angular/core";
import {IonAlert, IonBadge} from "@ionic/angular/standalone";
import {NgClass, NgForOf, NgIf} from "@angular/common";
import {StorageService} from "../../../../services/storage.service";
import {GoogleCalendarService} from "../../../../services/google-calendar.service";
import {WEEKDAYS_CACHE_EXPIRED_IN_KEY, WEEKDAYS_KEY} from "../../../utils/constants";
import {Weekday} from "../../../models/weekday";

@Component({
  standalone: true,
  selector: "app-date-slider-component",
  template: `
    <div id="container" #container>
      <div
        #items
        id="items"
        *ngFor="
          let weekday of weekdays;
          trackBy:trackDateList;
        "
        [ngClass]="{
          'active': activeDay === weekday?.date,
          'holiday': weekday?.isHoliday,
          'lock': weekday.date!! > today()
        }"
        (click)="setActiveDay(weekday)"
      >
        <h4>{{ weekday?.day }}</h4>
        <h3>{{ weekday?.date }}</h3>
        <h5>{{ weekday?.month }}</h5>
        <ng-template [ngIf]="
            today() === weekday?.date &&
            activeDay !== weekday?.date
        ">
          <div class="today"></div>
        </ng-template>
      </div>
    </div>

    <ion-alert
      mode="md"
      [isOpen]="isAlertOpen"
      header="Perhatian"
      subHeader="Anda hanya bisa memilih hari ini atau hari sebelumnya"
      (didDismiss)="setOpenAlert(false)"
      [buttons]="alertButtons"
    ></ion-alert>
  `,
  styles: [`
    #container {
      display: flex;
      flex-direction: row;
      overflow-x: auto;
      padding: 16px;
      margin: 0 -16px;
      gap: 20px;
      &::-webkit-scrollbar {display: none;}
      #items {
        background: var(--ion-color-bg-grey);
        border-radius: 8px;
        padding: 16px;
        display: flex;
        position: relative;
        flex-direction: column;
        text-align: center;
        width: 100px;
        h3 {font-size: 3rem;}
        h4 {font-size: 1.1rem;}
        h5 {font-size: 0.9rem;}
        h5, h4, h3 {
          padding: 0;
          margin: 0;
          font-weight: normal;
        }
        &.active {
          background-color: var(--ion-color-success);
          h5, h4, h3 {color: white;font-weight: bold;
          }
          &:hover {background-color: var(--ion-color-success);}
        }
        &.holiday {
          h5, h4, h3 {color: white;}
          background: var(--ion-color-danger);
          &:hover {background-color: var(--ion-color-danger);}
          &.lock {
            background-color: #eebbc0;
            h5, h4, h3 {color: #eae5e5;}
          }
        }
        &:hover {background-color: var(--ion-color-bg-grey-2);}
        &.lock {
          background-color: #dedede;
          h5, h4, h3 {color: #f3f3f3;}
        }
      }
      .today {
        background: var(--ion-color-primary);
        position: absolute;
        top: 5px;
        right: 5px;
        padding: 8px;
        transform: translate(50%, -50%);
        border-radius: 50%;
        animation: blink 2.5s infinite;
      }
    }
    @keyframes blink {
      0%, 100% {opacity: 1;}
      50% {opacity: 0;}
    }
  `],
  imports: [
    NgForOf,
    NgClass,
    NgIf,
    IonBadge,
    IonAlert,
  ]
})
export class DateSliderComponent implements OnInit {
  @Output() callback = new EventEmitter<Weekday>();
  @ViewChild('container') container!: ElementRef;
  @ViewChildren('items') items!: QueryList<ElementRef>;

  weekdays: Weekday[] = [];
  todayIndex: number = -1;
  activeDay: number = 0;

  isAlertOpen: boolean = false;
  alertButtons = ['OK'];

  constructor(
    private storageService:  StorageService,
    private googleCalendarService: GoogleCalendarService
  ) {}

  async ngOnInit() {
    // ? why use setTimeout?
    //
    // this because the ionic storage seems cannot load the data immediately,
    // so we need to wait for a while to make sure the data is loaded properly
    //
    // load weekdays after 1ms
    setTimeout(() =>  this.loadWeekdays(), 1)
    // scroll to today after 100ms to make sure the container is ready
    setTimeout(() => this.scrollToToday(), 100)
  }

  /**
   * Load weekdays
   *
   * this method will load weekdays from storage
   * if weekdays cache is expired, it will get month dates
   * and save it to storage
   * holiday will be fetched from Google calendar
   * and weekends & weekdays will be calculated
   *
   * @return void
   */
  async loadWeekdays() {
    // check if weekdays cache is expired
    this.storageService.get(WEEKDAYS_CACHE_EXPIRED_IN_KEY).then((expiredIn) => {
      const currentTimeInMillis = Date.now();
      if (currentTimeInMillis >= expiredIn) {
        this.storageService.remove(WEEKDAYS_KEY)
        this.storageService.remove(WEEKDAYS_CACHE_EXPIRED_IN_KEY)
      }
    })
    // load weekdays from storage
    const savedWeekdays = await this.storageService.get(WEEKDAYS_KEY);
    if (savedWeekdays) {
      this.weekdays = savedWeekdays;
      return;
    }
    // build weekdays and get holidays from Google calendar
    await this.getMonthDates();
  }

  /**
   * Get month dates
   *
   * this method will get month dates and save it to storage
   * holiday will be fetched from Google calendar
   * and weekends & weekdays will be calculated
   *
   * @return void
   *
   */
  getMonthDates = async () => {
    const { firstDay, lastDay } = this.getFirstAndLastDayInCurrentMonth();
    // get public holidays
    this.googleCalendarService.getHolidayBetweenDates(
      this.formatDate(firstDay),
      this.formatDate(lastDay),
    ).subscribe(next => {
      // get weekends & weekdays
      for (let date = firstDay; date <= lastDay; date.setDate(date.getDate() + 1)) {
        this.getDayInfo(date, next?.items, lastDay.getTime());
      }
      // scroll to today
      setTimeout(() => this.scrollToToday(), 100)
    });
  }

  /**
   *
   * Get day info
   *
   * this method will get day info and save it to storage
   *
   * @param date
   * @param holidays
   * @param cacheExpiredIn
   */
  async getDayInfo(date: Date, holidays: any[], cacheExpiredIn: number) {
    // set base data
    let day: Weekday = {
      fullDate: this.formatDate(date),
      day: date.toLocaleDateString('id-ID', {weekday: 'long'}),
      date: parseInt(date.getDate().toString().padStart(2, '0')),
      month: date.toLocaleDateString('id-ID', {month: 'long'}),
      year: date.getFullYear(),
      isHoliday: false,
      holiday: "",
    }
    // set weekends
    if (date.getDay() === 0 || date.getDay() === 6) {
      day.isHoliday = true;
      day.holiday = "Akhir pekan";
    }
    // set public holidays
    holidays?.forEach((item: any) => {
      if (item.date === this.formatDate(date)) {
        day.isHoliday = true;
        day.holiday = item.summary;
      }
    });
    // push day to weekdays
    this.weekdays.push(day);
    // save weekdays to storage
    await this.storageService.set(WEEKDAYS_KEY, this.weekdays)
    await this.storageService.set(WEEKDAYS_CACHE_EXPIRED_IN_KEY, cacheExpiredIn)
  }

  /**
   * Get first and last day in current month
   *
   * @return {firstDay: Date, lastDay: Date}
   */
  getFirstAndLastDayInCurrentMonth = (): {firstDay: Date, lastDay: Date} => {
    const currentDate = new Date();
    const firstDay = new Date(currentDate.getFullYear(),
      currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(),
      currentDate.getMonth() + 1, 0);
    return {firstDay, lastDay};
  }

  // format date to yyyy-MM-dd
  formatDate = (date: Date): string => `${date.getFullYear()}-` +
    `${(date.getMonth() + 1).toString().padStart(2, '0')}-`+
    `${date.getDate().toString().padStart(2, '0')}`;

  // track date list by index and date object day name
  // to avoid re-rendering the list when the date is changed or updated
  trackDateList = (index: any, date: any): string =>  date?.day + index

  // get today date
  today = (): number => parseInt((new Date()).getDate().toString().padStart(2, '0'))

  /**
   * Scroll to today
   *
   * this method will scroll to today item
   * and make sure the today item is in the middle of the container
   *
   * @return void
   */
  scrollToToday(): void {
    // set today item
    this.setTodayItem();
    // if today index is not found or items length is empty
    if (this.todayIndex === -1 && this.items.length <= 0 && !this.container) return;
    // find today item
    const todayItem = this.items.toArray()[this.todayIndex];
    // if today item not found
    if (!todayItem) return;
    // scroll to today item
    const containerRect = this.container.nativeElement.getBoundingClientRect();
    const itemRect = todayItem.nativeElement.getBoundingClientRect();
    const scrollLeft = itemRect.left - containerRect.left - (containerRect.width - itemRect.width) / 2;
    this.container.nativeElement.scrollTo({ left: scrollLeft, behavior: 'smooth' });
  }

  /**
   * Set today item
   *
   * this method will set today item index
   *
   * @return void
   */
  setTodayItem(): void {
    // set today date
    this.activeDay = this.today();
    // set today index
    this.todayIndex = this.weekdays.findIndex(weekday =>
      weekday.date === this.activeDay);
    // set active day
    this.setActiveDay(this.weekdays[this.todayIndex])
  }

  /**
   * Set active day
   *
   * this method will activate day card,
   * emit callback event to parent component and
   * scroll to selected day card
   *
   * @param weekday
   * @return void
   */
  setActiveDay(weekday: Weekday): void {
    if (weekday.date!! > this.today()) {
      this.setOpenAlert(true);
      return;
    }
    this.activeDay = weekday.date!!;
    this.callback.emit(weekday);
    this.scrollToSelectedDay(weekday);
  }

  /**
   * Scroll to selected day
   *
   * this method will scroll to selected day card
   * and make sure the selected day card is in the middle of the container
   *
   * @param selectedDay
   * @return void
   */
  scrollToSelectedDay(selectedDay: Weekday): void {
    // if container not found or items length is empty
    if (!this.container && this.items.length <= 0) return;
    // find selected day item
    const selectedDayItem = this.items.toArray()
      .find(item => item.nativeElement
        .innerText.includes(selectedDay.date!!.toString()));
    // if selected day not found
    if (!selectedDayItem) return;
    // scroll to selected day
    const containerWidth = this.container.nativeElement.offsetWidth;
    const itemWidth = selectedDayItem.nativeElement.offsetWidth;
    const itemOffsetLeft = selectedDayItem.nativeElement.offsetLeft;
    const scrollLeft = itemOffsetLeft - (containerWidth - itemWidth) / 2;
    this.container.nativeElement.scrollTo({ left: scrollLeft, behavior: 'smooth' });
  }

  // set open alert state
  setOpenAlert(open: boolean): void {
    this.isAlertOpen = open;
  }
}
