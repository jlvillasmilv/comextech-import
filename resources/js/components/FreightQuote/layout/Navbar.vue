<template>
  <!-- <nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
      <svg
        class="fill-current h-8 w-8 mr-2"
        width="54"
        height="54"
        viewBox="0 0 54 54"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"
        />
      </svg>
      <span class="font-semibold text-xl tracking-tight">Tailwind CSS</span>
    </div>
    <div class="block lg:hidden">
      <button
        class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white"
      >
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <title>Menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </button>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
      <div class="text-sm lg:flex-grow">
        <a
          href="#responsive-header"
          class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
          Docs
        </a>
        <a
          href="#responsive-header"
          class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
          Examples
        </a>
        <a
          href="#responsive-header"
          class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white"
        >
          Blog
        </a>
      </div>
      <div>
        <a
          href="#"
          class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0"
          >Download</a
        >
      </div>
    </div>
  </nav> -->
  <nav class="bg-white px-8 sm:px-8 shadow-md py-2 mb-8">
    <div class="flex flex-col md:flex-row justify-between">
      <a class="flex justify-between items-center">
        <img src="../../../../../public/img/LogoComexTech.png" alt="" class="w-44" />
        <div class="flex justify-end">
          <!-- <button
            data-collapse-toggle="mobile-menu"
            type="button"
            class="w-10 flex justify-end items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="mobile-menu-2"
            aria-expanded="false"
          > -->
          <svg
            @click="showMenu()"
            class="w-6 h-6 md:hidden"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <svg
            class="hidden w-6 h-6"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <!-- </button> -->
        </div>
      </a>
      <div :class="[{ hidden: showBurgerMenu }, 'md:block w-full md:w-auto']" id="mobile-menu">
        <ul
          class="flex flex-col justify-end md:items-center mt-8 md:flex-row md:space-x-2 md:mt-0 md:text-sm md:font-medium"
        >
          <li>
            <a
              href="#"
              class="w-24 text-center block py-3 rounded text-white bg-blue-1000 hover:bg-blue-1300"
              aria-current="page"
              >Inicio</a
            >
          </li>
          <li>
            <a
              href="#"
              class="w-24 text-center block py-3 rounded text-gray-700 hover:bg-blue-1000 hover:text-white active:bg-blue-1300"
              >Nosotros</a
            >
          </li>
          <li>
            <a
              href="#"
              class="w-24 text-center block py-3 rounded text-gray-700 hover:bg-blue-1000 hover:text-white active:bg-blue-1300"
              >Servicios</a
            >
          </li>
          <li>
            <a
              href="#"
              class="w-24 text-center block py-3 rounded text-gray-700 hover:bg-blue-1000 hover:text-white active:bg-blue-1300"
              >Contacto</a
            >
          </li>
          <li>
            <a
              href="#"
              class="uppercase w-36 md:w-28 text-center block py-3 rounded text-gray-700 hover:bg-blue-1000 hover:text-white active:bg-blue-1300"
              >Cotice Online</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      showBurgerMenu: true
    };
  },
  methods: {
    showMenu() {
      this.showBurgerMenu = !this.showBurgerMenu;
    }
  }
};
</script>

<style></style>
