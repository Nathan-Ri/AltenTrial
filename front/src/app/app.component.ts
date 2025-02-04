import {
  Component, inject, OnInit, WritableSignal,
} from "@angular/core";
import { RouterModule } from "@angular/router";
import { SplitterModule } from 'primeng/splitter';
import { ToolbarModule } from 'primeng/toolbar';
import { PanelMenuComponent } from "./shared/ui/panel-menu/panel-menu.component";
import {Button, ButtonDirective} from "primeng/button";
import {DialogModule} from "primeng/dialog";
import {FormsModule} from "@angular/forms";
import {CartComponent} from "./products/features/cart/cart.component";
import {BadgeModule} from "primeng/badge";
import {CartService} from "./products/data-access/cart.service";

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.scss"],
  standalone: true,
  imports: [RouterModule, SplitterModule, ToolbarModule, PanelMenuComponent, Button, DialogModule, FormsModule, CartComponent, BadgeModule, ButtonDirective],
})
export class AppComponent implements OnInit{
  title = "ALTEN SHOP";
  cartVisible: boolean | WritableSignal<boolean> = false;
  private readonly cartService = inject(CartService);
  protected readonly total = this.cartService.total


  ngOnInit() {
    this.cartService.getTotalQuantity();
  }


}
