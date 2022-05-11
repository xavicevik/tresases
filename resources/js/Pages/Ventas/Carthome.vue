<template>

    <form method="POST" action="http://127.0.0.1:8000/cart">

        <div class="form-group">
            <label for="id">ID</label>
            <input type="text" name="id" class="form-control" id="id">
        </div>
        <div class="form-group">
            <label for="name">NOMBRE</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="price">PRECIO</label>
            <input type="text" name="price" class="form-control" id="price">
        </div>
        <div class="form-group">
            <label for="quantity">CANTIDAD</label>
            <input type="text" name="quantity" class="form-control" id="quantity">
        </div>
        <div class="form-group">
            <label for="color">COLOR</label>
            <select class="form-control" name="color" id="color">
                <option value="blanco">blanco</option>
                <option value="azul"> azul</option>
            </select>
            <small class="form-text text-muted">Atributo</small>
        </div>

        <div class="form-group">
            <label for="tamano">TAMAÑO</label>
            <select name="tamano" class="form-control" id="tamano">
                <option value="chico">Chico</option>
                <option value="grande">Grande</option>
            </select>
            <small class="form-text text-muted">Atributo</small>
        </div>
        <button type="submit" class="btn btn-primary">Agregar al carrito</button>
    </form>
</template>

<script>
export default {
    name: "carthome"
}
</script>

<style scoped>

</style>
