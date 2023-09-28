export { VisitorProgress }


// =========================================================================


// game config
const CONF = {
    // version of the current save data
    // integer: > 0
    data_version: 1,

    // amount of time that has to pass before the next progress is possible
    // integer (milliseconds): >= 0
    progress_delay: 3_600_000,

    // how much time passes in-game in one real-life second
    // integer (in-game seconds): > 0
    seconds_duration: 600,

    // average walking speed of the player
    // float (km/h): > 0
    walking_speed: 3.89,

    // maximum unique items to hold in the inventory
    // integer (slots): >= 1
    inventory_size: 10,

    // first loot chance value
    // float (percent): 0.0 - 1.0
    loot_chance_1: 0.79,

    // second loot chance value
    // float (percent): 0.0 - 1.0
    loot_chance_2: 0.64,

    // chance that a item name gets a prefix
    // float (percent): 0.0 - 1.0
    item_name_prefix_chance: 0.43,

    // chance that a item name gets a suffix
    // float (percent): 0.0 - 1.0
    item_name_suffix_chance: 0.07,

    // item base value divider
    // float|integer (number): experiment
    item_value_modifier: 31.337,
}


// default player data
const DEFAULT_DATA: VP_Storage_Data = {
    // version of the current save data
    data_version: CONF.data_version,

    // whether the visitor is opted-in for playing or not
    opt_in: false,

    // when the visitor has opted-in for playing
    started_playing_on: 0,

    // when the last progress was triggered
    last_progress_on: 0,

    // game/player stats
    stats: {
        ingame_time_passed: {
            years: 0,
            months: 0,
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
        },
        distance_traveled: 0,
        currency_gained: 0,
        loot_found: 0,
        loot_sold: 0,
        top_loot: {
            name: '',
            value: 0,
            discovered_on: 0,
        },
    },

    // inventory holding loot items not sold yet
    inventory: {},
}


// loot item name strings
const LOOT_ITEMS = {
    prefix: [
        'ancient',
        'beautiful',
        'bended',
        'bitten',
        'bleeding',
        'bloodmoon',
        'bloody',
        'broken',
        'chirping',
        'cinder',
        'clay',
        'cork',
        'cracked',
        'dripping',
        'dusty',
        'electric',
        'fake',
        'flaming',
        'glass',
        'glow',
        'golden',
        'green',
        'half',
        'iron',
        'jagged',
        'knocked',
        'latex',
        'lunatic',
        'magic',
        'mistery',
        'model',
        'pierced',
        'pitch black',
        'plastic',
        'poket',
        'rainbow',
        'repaired',
        'ripped',
        'rubber',
        'rusty',
        'sand',
        'shiny',
        'silver',
        'singing',
        'solar',
        'spoiled',
        'stabilized',
        'steel',
        'torn',
        'used',
        'white',
    ],
    name: [
        'aegis',
        'air freshener',
        'apple',
        'armour',
        'arrow',
        'audio cassette',
        'axe',
        'backpack',
        'bag',
        'balloon',
        'banana',
        'band',
        'banner',
        'bed',
        'berry',
        'blade',
        'blanket',
        'block',
        'blouse',
        'book',
        'boom box',
        'bottle',
        'bottle cap',
        'bow',
        'bowl',
        'box',
        'bracelet',
        'bread',
        'brick',
        'brocolli',
        'bug net',
        'bullet',
        'button',
        'cable',
        'camera',
        'candle',
        'candy wrapper',
        'canvas',
        'carnwennan',
        'carrot',
        'cell phone',
        'chainmail',
        'chair',
        'chalk',
        'charger',
        'checkbook',
        'cheesecake bomb',
        'chocolate',
        'clamp',
        'cloak',
        'clock',
        'club',
        'coat',
        'coin',
        'computer',
        'cookie jar',
        'couch',
        'courtain',
        'credit card',
        'crown',
        'cup',
        'dagger',
        'danceshoe',
        'dart',
        'deodorant',
        'desk',
        'diadem',
        'didgeridoo',
        'doll',
        'door',
        'dragon tooth',
        'sandwich',
        'eraser',
        'eye',
        'eye liner',
        'face wash',
        'finger glove',
        'fingernail',
        'flag',
        'flint',
        'floor',
        'flower',
        'fork',
        'fridge',
        'glasses',
        'greeting card',
        'grid paper',
        'gucci bag',
        'hair brush',
        'hair tie',
        'cigarette',
        'hammer',
        'hand fan',
        'harmonica',
        'harpoon',
        'harve',
        'headband',
        'headphones',
        'headset',
        'helmet',
        'hoody',
        'horn',
        'ice cube tray',
        'ingot',
        'key',
        'key chain',
        'keyboard',
        'knife',
        'lace',
        'lamp',
        'lamp shade',
        'lance',
        'lip gloss',
        'lockbox',
        'lotion',
        'magnet',
        'mammoth',
        'mask',
        'medallion',
        'microphone',
        'microwave',
        'milk',
        'mini-disc',
        'mirror',
        'monitor',
        'mouse pad',
        'mp3 player',
        'nail',
        'nail clipper',
        'nail file',
        'neclace',
        'needle',
        'nuke',
        'paint brush',
        'palm fan',
        'paper',
        'peanut',
        'pearl',
        'pen',
        'pencil',
        'perfume',
        'phone',
        'photo album',
        'piano',
        'picture frame',
        'pill',
        'pillow',
        'pipe',
        'pitchfork',
        'plate',
        'playing card',
        'pool stick',
        'pot',
        'puppet',
        'purse',
        'radio',
        'rifle',
        'ring',
        'rod',
        'rug',
        'sandal',
        'screw',
        'scythe',
        'seat belt',
        'shampoo',
        'shield',
        'shirt',
        'shoe lace',
        'shoe',
        'shovel',
        'slipper',
        'soap',
        'sock',
        'soda can',
        'spaghetti',
        'speaker',
        'spear',
        'spikewheel',
        'sponge',
        'spoon',
        'spring',
        'staff',
        'stick',
        'stone shard',
        'sun glasses',
        'sword',
        'syringe',
        'tail',
        'television',
        'thermometer',
        'thermostat',
        'thorn',
        'thread',
        'tissue box',
        'tomahawk',
        'tomato',
        'tome',
        'tooth',
        'tooth pick',
        'toothbrush',
        'toothpaste',
        'towel',
        'toy',
        'tree',
        'truck',
        'twezzer',
        'twister',
        'uno card',
        'usb drive',
        'vape',
        'vase',
        'vhs cassette',
        'video game',
        'vinyl record',
        'wagon',
        'walkman',
        'wallet',
        'wand',
        'washing machine',
        'watch',
        'water bottle',
        'window',
        'winebottle',
        'zipper',
    ],
    suffix: [
        'from the depths',
        'from the east',
        'from the north',
        'from the south',
        'from the west',
        'of a centaur',
        'of doom',
        'of glory',
        'of happiness',
        'of immortality',
        'of invisibility',
        'of justice',
        'of love',
        'of luck',
        'of pain',
        'of sasquatsch',
        'of terror',
        'of the broken unicorn',
        'of the district',
        'of the fairy',
        'of the mooncult',
        'of the south',
        'of the sun',
        'of thorns',
    ],
}


// =========================================================================


type VP_Storage_Data = {
    data_version: number,
    opt_in: boolean,
    started_playing_on: number,
    last_progress_on: number,
    stats: {
        ingame_time_passed: {
            years: number,
            months: number,
            days: number,
            hours: number,
            minutes: number,
            seconds: number,
        },
        distance_traveled: number,
        currency_gained: number,
        loot_found: number,
        loot_sold: number,
        top_loot: {
            name: string,
            value: number,
            discovered_on: number,
        },
    },
    inventory: {
        [key: string]: {
            count: number,
            value_per_item: number,
            value_per_batch: number,
        },
    },
}


class VisitorProgress
{
    // whether the local storage is available or not
    storage_ready: boolean = false

    // local storage object
    #Storage: Storage = window.localStorage

    // the key for the local storage data
    #data_key: string = 'VisitorProgress'

    // default player data
    #default_data: VP_Storage_Data = DEFAULT_DATA

    // current player data
    #data: VP_Storage_Data = this.#default_data


    constructor() {
        try {
            this.#Storage.setItem(`${this.#data_key}_test`, 'test')
            this.#Storage.removeItem(`${this.#data_key}_test`)
            this.storage_ready = true
        }
        catch (error) {
            console.error('local storage is not available:', error)
            return
        }

        this.#load_data()
    }


    get opt_in(): boolean
    {
        return this.#data.opt_in
    }


    set opt_in(value: boolean)
    {
        if (!this.storage_ready || value === this.#data.opt_in) return

        this.#data.opt_in = value

        if (value === true) {
            this.#data.started_playing_on = Date.now()
            this.#save_data()
        }
        else {
            this.#data = this.#default_data
            this.#Storage.removeItem(this.#data_key)
        }
    }


    get current_data(): VP_Storage_Data
    {
        this.#load_data()
        return this.#data
    }


    progress(): void
    {
        if (
            !this.storage_ready
            || !this.opt_in
            || Date.now() - this.#data.last_progress_on < CONF.progress_delay
        ) return

        this.#data.last_progress_on = Date.now()

        this.#pass_time()
        this.#walk()
        this.#sell_loot()
        this.#find_loot()
        this.#save_data()
    }


    #load_data(): boolean
    {
        if (!this.storage_ready) return false

        const dump = this.#Storage.getItem(this.#data_key)

        if (!dump) return true // using already set default data

        try {
            this.#data = JSON.parse(atob(dump))

            if (this.#data.data_version != CONF.data_version) {
                console.warn('progress reset because data structure was updated')
                this.#data = this.#default_data
                this.#data.opt_in = true
                this.#data.started_playing_on = Date.now()
            }

            return true
        }
        catch (error) {
            this.#data = this.#default_data
            this.#Storage.removeItem(this.#data_key)
            console.error('failed to decode storage data:', error)
            return false
        }
    }


    #save_data(): boolean
    {
        if (!this.storage_ready) return false

        try {
            const dump = btoa(JSON.stringify(this.#data))
            this.#Storage.setItem(this.#data_key, dump)
            return true
        }
        catch (error) {
            console.error('failed to save data:', error)
            return false
        }
    }


    #pass_time(): void
    {
        this.#data.stats.ingame_time_passed.seconds = ((Date.now() - this.#data.started_playing_on) / 1_000) * CONF.seconds_duration
        this.#data.stats.ingame_time_passed.minutes = this.#data.stats.ingame_time_passed.seconds / 60
        this.#data.stats.ingame_time_passed.hours = this.#data.stats.ingame_time_passed.seconds / 3_600
        this.#data.stats.ingame_time_passed.days = this.#data.stats.ingame_time_passed.seconds / 86_400
        this.#data.stats.ingame_time_passed.months = this.#data.stats.ingame_time_passed.seconds / 2_592_000
        this.#data.stats.ingame_time_passed.years = this.#data.stats.ingame_time_passed.seconds / 31_536_000
    }


    #walk(): void
    {
        this.#data.stats.distance_traveled = CONF.walking_speed * this.#data.stats.ingame_time_passed.hours
    }


    #sell_loot(): void
    {
        if (Object.keys(this.#data.inventory).length < CONF.inventory_size) return

        const item_count = Object.values(this.#data.inventory).reduce((acc, val) => acc + val.count, 0)
        const income = Object.values(this.#data.inventory).reduce((acc, val) => acc + (val.value_per_item * val.count), 0)

        this.#data.stats.currency_gained += income

        this.#data.stats.loot_sold += item_count

        this.#data.inventory = {}
    }


    #find_loot(): void
    {
        if (
            Math.random() > CONF.loot_chance_1
            || Math.random() > CONF.loot_chance_2
        ) return

        const item_name: string = this.#get_random_item_name()
        const item_value = this.#get_item_value(item_name)
        const count: number = (this.#data.inventory[item_name]?.count ?? 0) + 1

        this.#data.inventory[item_name] = {
            count: count,
            value_per_item: item_value,
            value_per_batch: item_value * count
        }

        this.#data.stats.loot_found += 1

        if (item_value > this.#data.stats.top_loot.value) {
            this.#data.stats.top_loot.name = item_name
            this.#data.stats.top_loot.value = item_value
            this.#data.stats.top_loot.discovered_on = Date.now()
        }
    }


    #get_random_item_name(): string
    {
        const item_name: string[] = []

        if (Math.random() < CONF.item_name_prefix_chance) item_name.push(LOOT_ITEMS.prefix[Math.floor(Math.random() * LOOT_ITEMS.prefix.length)] as string)
        item_name.push(LOOT_ITEMS.name[Math.floor(Math.random() * LOOT_ITEMS.name.length)] as string)
        if (Math.random() < CONF.item_name_suffix_chance) item_name.push(LOOT_ITEMS.suffix[Math.floor(Math.random() * LOOT_ITEMS.suffix.length)] as string)

        return item_name.join(' ').toLowerCase()
    }


    #get_item_value(item_name: string): number
    {
        const char_value: {
            [key: string]: number
        } = {
            'a': 0.11,
            'b': 0.22,
            'c': 0.33,
            'd': 0.44,
            'e': 0.55,
            'f': 0.66,
            'g': 0.77,
            'h': 0.88,
            'i': 0.99,
            'j': 1.11,
            'k': 1.22,
            'l': 1.33,
            'm': 1.44,
            'n': 1.55,
            'o': 1.66,
            'p': 1.77,
            'q': 1.88,
            'r': 1.99,
            's': 2.11,
            't': 2.22,
            'u': 2.33,
            'v': 2.44,
            'w': 2.55,
            'x': 2.66,
            'y': 2.77,
            'z': 2.88,
        }

        const dump = item_name.trim().toLowerCase().split('')
        let item_value = item_name.length

        for (const char of dump) item_value += char_value[char] ?? 0.1

        item_value = item_value / CONF.item_value_modifier

        return item_value
    }
}
