import {Component, inject} from '@angular/core';
import {FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators} from "@angular/forms";
import {InputTextModule} from "primeng/inputtext";
import {InputTextareaModule} from "primeng/inputtextarea";
import {ToastModule} from "primeng/toast";
import {UsersService} from "../data-access/users.service";

@Component({
  selector: 'app-create',
  standalone: true,
  imports: [
    FormsModule,
    InputTextModule,
    InputTextareaModule,
    ReactiveFormsModule,
    ToastModule
  ],
  templateUrl: './create-user.component.html',
})
export class CreateUserComponent {
  private userService: UsersService = inject(UsersService)
  protected formGroup: FormGroup;
  constructor() {
    this.formGroup = new FormGroup({
      email: new FormControl<String | null>(null, [Validators.required, Validators.email]),
      password: new FormControl<String | null>(null, [Validators.required]),
    });
  }

  onSubmit() {
    this.userService.create(this.formGroup.value).subscribe()
    // this.formGroup.reset()
  }

}
