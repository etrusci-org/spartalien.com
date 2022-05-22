// IT'S BEEN A WHILE SINCE I WROTE TS

interface AppInterface {
    main(): void
    loadLazyMedia(): void
}

const App: AppInterface = {
    main() {
        console.log('spartalien.com');
    },
    loadLazyMedia() {
        // ele = all: .lazyMedia data-slug
        // foreach ele as v
        //     replace with embed code
    },
}
