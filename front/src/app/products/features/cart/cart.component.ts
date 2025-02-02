import {Component, inject, OnInit} from '@angular/core';
import {CartService} from "../../data-access/cart.service";
import {CardModule} from "primeng/card";
import {DataViewModule} from "primeng/dataview";
import {PrimeTemplate} from "primeng/api";
import {Button, ButtonDirective} from "primeng/button";
import {Product} from "../../data-access/product.model";

@Component({
  selector: 'app-cart',
  standalone: true,
  imports: [
    CardModule,
    DataViewModule,
    PrimeTemplate,
    Button,
    ButtonDirective
  ],
  templateUrl: './cart.component.html',
})
export class CartComponent implements OnInit {
  private readonly cartService = inject(CartService);
  protected readonly cart = this.cartService.cart



  ngOnInit() {
    this.cartService.get();
  }

  removeFromCart(product: Product) {
    this.cartService.removeFromCart(product)
  }
}
