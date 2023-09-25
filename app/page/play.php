<h2>VisitorProgress</h2>



<div class="stats hide box">
    <h3>Your Progress</h3>

    <div class="grid-x-2">
        <p>
            <strong>Started playing on</strong><br>
            <span class="started_playing_on"></span>
        </p>
        <p>
            <strong>Last progress on</strong><br>
            <span class="last_progress_on"></span>
        </p>
    </div>

    <p>
        <strong>Time passed</strong><br>
        <span class="ingame_time_passed"></span>
    </p>

    <div class="grid-x-2">
        <p>
            <strong>Distance traveled</strong><br>
            <span class="distance_traveled"></span>
        </p>

        <p>
            <strong>Currency gained</strong><br>
            <span class="currency_gained"></span>
        </p>
    </div>

    <div class="grid-x-2">
        <div>
            <p>
                <strong>Items found</strong><br>
                <span class="loot_found"></span>
            </p>

            <p>
                <strong>Items sold</strong><br>
                <span class="loot_sold"></span>
            </p>
        </div>

        <p>
            <strong>Top item by value</strong><br>
            <span class="top_loot"></span>
        </p>
    </div>

    <strong>Backpack (<span class="free_inventory_slots"></span>/<code>50</code>)</strong>
    <table>
        <thead>
            <tr>
                <td>Item</td>
                <td>Count</td>
                <td>Value/Item</td>
                <td>Value/Batch</td>
            </tr>
        </thead>
        <tbody class="inventory"></tbody>
    </table>
</div>



<!-- <div class="box"> -->
    <!-- <p>Game description goes here once I figured it out...</p> -->
    <p><button class="optin_toggle"></button></p>
<!-- </div> -->







<script type="module">
    import { VisitorProgress } from './res/visitorprogress.js'

    const VP = new VisitorProgress()

    if (VP.opt_in) VP.progress() // TODO: remove me when done creating page, no progress on this overview page

    const optin_toggle = document.querySelector('.optin_toggle')
    const stats = document.querySelector('.stats')
    const started_playing_on = document.querySelector('.started_playing_on')
    const last_progress_on = document.querySelector('.last_progress_on')
    const ingame_time_passed = document.querySelector('.ingame_time_passed')
    const distance_traveled = document.querySelector('.distance_traveled')
    const currency_gained = document.querySelector('.currency_gained')
    const loot_found = document.querySelector('.loot_found')
    const loot_sold = document.querySelector('.loot_sold')
    const top_loot = document.querySelector('.top_loot')
    const inventory = document.querySelector('.inventory')
    const free_inventory_slots = document.querySelector('.free_inventory_slots')
    const cursymbol = '◈'
    const decdigits = 3

    optin_toggle.addEventListener('click', (event) => {
        event.preventDefault()
        if (!VP.opt_in) {
            VP.opt_in = true
            update_display()
        }
        else {
            if (!confirm('This will purge all your progress!\nAre you sure?\nReally?\n...\nAre you really really sure??')) return
            VP.opt_in = false
            update_display(true)
        }
    }, false)


    const update_data_display = () => {
        // console.table(VP.current_data)

        if (VP.opt_in) {
            stats.classList.remove('hide')
            optin_toggle.textContent = 'reset progress'
        }
        else {
            stats.classList.add('hide')
            optin_toggle.textContent = 'start playing'
        }

        started_playing_on.innerHTML = `<code>${new Date(VP.current_data.started_playing_on).toUTCString()}</code>`
        last_progress_on.innerHTML = `<code>${new Date(VP.current_data.last_progress_on).toUTCString()}</code>`
        ingame_time_passed.innerHTML = `
            <code>${VP.current_data.stats.ingame_time_passed.years.toFixed(decdigits)}</code> years
            <code>${VP.current_data.stats.ingame_time_passed.months.toFixed(decdigits)}</code> months
            <code>${VP.current_data.stats.ingame_time_passed.days.toFixed(decdigits)}</code> days
            <code>${VP.current_data.stats.ingame_time_passed.hours.toFixed(decdigits)}</code> hours
            <code>${VP.current_data.stats.ingame_time_passed.minutes.toFixed(decdigits)}</code> minutes
            <code>${VP.current_data.stats.ingame_time_passed.seconds.toFixed(decdigits)}</code> seconds`
        distance_traveled.innerHTML = `<code>${VP.current_data.stats.distance_traveled.toFixed(decdigits)}</code> km`
        currency_gained.innerHTML = `<code>${VP.current_data.stats.currency_gained.toFixed(decdigits)}</code> ${cursymbol}`
        loot_found.innerHTML = `<code>${VP.current_data.stats.loot_found}</code>`
        loot_sold.innerHTML = `<code>${VP.current_data.stats.loot_sold}</code>`
        if (!VP.current_data.stats.top_loot.name) {
            top_loot.innerHTML = '<em>none so far</em>'
        }
        else {
            top_loot.innerHTML = `
                Item: <code>${VP.current_data.stats.top_loot.name}</code><br>
                Value: <code>${VP.current_data.stats.top_loot.value.toFixed(decdigits)}</code> ${cursymbol}<br>
                Discovered on: <code>${new Date(VP.current_data.stats.top_loot.discovered_on).toUTCString()}</code>`
        }

        if (Object.keys(VP.current_data.inventory).length == 0) {
            inventory.innerHTML = '<tr colspan="4"><td><em>empty</em></td></tr>'
        }
        else {
            inventory.innerHTML = ''
            for (const item_name in VP.current_data.inventory) {
                inventory.innerHTML += `
                    <tr>
                        <td><code>${item_name}</code></td>
                        <td><code>${VP.current_data.inventory[item_name].count}</code></td>
                        <td><code>${VP.current_data.inventory[item_name].value_per_item.toFixed(decdigits)}</code> ${cursymbol}</td>
                        <td><code>${(VP.current_data.inventory[item_name].value_per_batch != VP.current_data.inventory[item_name].value_per_item) ? `${VP.current_data.inventory[item_name].value_per_batch.toFixed(decdigits)} ${cursymbol}` : '-'}</code></td>
                    </tr>`
            }
        }
        free_inventory_slots.innerHTML = `<code>${Object.keys(VP.current_data.inventory).length}</code>`

    }


    update_data_display()




</script>
