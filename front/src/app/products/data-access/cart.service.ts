import {inject, Injectable, signal} from "@angular/core";
import {Product} from "./product.model";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: "root"
})
export class CartService {
  private readonly http = inject(HttpClient);
  private readonly path = "http://127.0.0.1:8000/api"; // je m'arrange un peu avec les / à la fin, mais en vrai on ferait un interceptor pour mettre la bonne url depuis un .env ou un truc comme ça

  private readonly _cart = signal<{ product: Product, quantity: number }[]>([]);
  public readonly cart = this._cart.asReadonly();

  private readonly _total = signal<number>(0)
  public readonly total = this._total.asReadonly();


  addToCart(product: Product): void {
    let cart = this.cart()
    let productInCart = cart.find((el) => el.product.internalReference === product.internalReference)
    if (productInCart) {
      productInCart.quantity++
    } else {
      cart.push({product: product, quantity: 1})
    }
    this._cart.set(cart)
    this.updateTotal()

    //ce bout de code sert juste de démonstration pour la mise en lien du cart dans le back end. j'ai pas syncro les entités
    this.http.post<any>(`${this.path}/carts/${product.id}/addToCart`, product).subscribe()
  }

  get(): { product: Product, quantity: number }[] {
    return this.cart()
  }

  getTotalQuantity(): number {
    return this.total()
  }

  private updateTotal() {
    const cart = this.cart()
    this._total.set(0)
    cart.map(el => this._total.set(this.total() + el.quantity))
  }

  removeFromCart(product: Product) {
    this._cart.set(
      this.cart().filter((el) => el.product.internalReference !== product.internalReference)
    )
    this.updateTotal()
  }
}
