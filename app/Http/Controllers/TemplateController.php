<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Illuminate\Support\Facades\DB;     // ← good to have for DB::raw
use App\Models\Ticket;
use Illuminate\Support\Str;
use App\Models\BookingItem;

class TemplateController extends Controller
{
      public function sign_up()
   {
return view('frontend.login.sign_up');
   }
       public function sign_in()
   {
return view('frontend.login.sign_in');
   }

   public function home(Request $request)
{
    $query = Event::query();

    $today = now()->startOfDay();

    // Get filters from URL
    $dateFilter = $request->query('date', 'all');
    $categoryFilter = $request->query('category', 'all');
    $eventTypeFilter = $request->query('event_type', 'all');

    // ALWAYS hide past events
    $query->where('event_date', '>=', $today);

    // DATE FILTER
    switch ($dateFilter) {
        case 'today':
            $query->whereDate('event_date', $today);
            break;
        case 'tomorrow':
            $query->whereDate('event_date', $today->copy()->addDay());
            break;
        case 'this_week':
            $query->whereBetween('event_date', [$today, $today->copy()->endOfWeek()]);
            break;
        case 'this_weekend':
            $query->whereBetween('event_date', [$today->copy()->endOfWeek()->subDays(2), $today->copy()->endOfWeek()]);
            break;
        case 'next_week':
            $query->whereBetween('event_date', [$today->copy()->addWeek()->startOfWeek(), $today->copy()->addWeek()->endOfWeek()]);
            break;
    }

    // CATEGORY FILTER
    if ($categoryFilter !== 'all') {
        $query->where('event_category', $categoryFilter);
    }

    // EVENT TYPE FILTER
    if ($eventTypeFilter !== 'all') {
        $query->where('event_type', $eventTypeFilter);
    }

    // Final filtered events
    $events = $query->orderBy('event_date', 'asc')->get();

    // Dynamic arrays for Blade dropdowns
    $eventTypes = Event::distinct()->pluck('event_type')->toArray(); // pull unique types from DB
    $categories = Event::distinct()->pluck('event_category')->toArray(); // pull unique categories from DB

    return view('frontend.home', compact(
        'events',
        'dateFilter',
        'categoryFilter',
        'eventTypeFilter',
        'eventTypes',
        'categories'
    ));
}

   public function edit()
   {
return view('frontend.pages.edit');
   }

   public function createevent()
   {
return view('frontend.createevent');
   }

      public function cr_online_event()
   {
return view('frontend.pages.create_online_event');
   }

      public function cr_venue_event()
   {
return view('frontend.pages.create_venue_event');
   }


 public function exploreevents(Request $request)
{
    // All event types your system supports
    $eventTypes = ['online','venue'];

    // All categories
    $categories = ['arts','business','concert','workshops','coaching','health','volunteer','sports','other'];

    // Optional date filters
    $dateFilters = [
        'today' => 'Today',
        'tomorrow' => 'Tomorrow',
        'week' => 'This Week',
        'month' => 'This Month',
    ];

    $query = Event::query();

    // Filter by event type
    if ($request->filled('event_type')) {
        $query->where('event_type', $request->event_type);
    }

    // Filter by category
    if ($request->filled('category')) {
        if ($request->category === 'free') {
            $query->where(function ($q) {
                $q->whereNull('price')->orWhere('price', 0);
            });
        } else {
            $query->where('event_category', $request->category);
        }
    }

    // Filter by date
    if ($request->filled('date')) {
        switch ($request->date) {
            case 'today':
                $query->whereDate('event_date', now());
                break;
            case 'tomorrow':
                $query->whereDate('event_date', now()->addDay());
                break;
            case 'week':
                $query->whereBetween('event_date', [now(), now()->addWeek()]);
                break;
            case 'month':
                $query->whereBetween('event_date', [now(), now()->addMonth()]);
                break;
        }
    }

    // Sort by event date
    $events = $query->orderBy('event_date', 'asc')->get();

    // Pass all needed variables to the view
    return view('frontend.pages.exploreevents', compact('events','categories','dateFilters','eventTypes'));
}

   public function venueevent(Request $request)
   {


      $id = $request->query('id')
        ?? $request->query('event_id')
        ?? $request->query('e');

    if (!$id) {
        return view('frontend.pages.venueevent', [
            'event'         => null,
            'error_message' => 'Event ID is required in the URL (example: ?id=5)'
        ]);
    }

    $event = Event::with(['tickets', 'organiser'])
                 ->find($id);

    if (!$event) {
        return view('frontend.pages.venueevent', [
            'event'         => null,
            'error_message' => "No event found with ID #{$id}"
        ]);
    }

    // IMPORTANT: Calculate sold tickets correctly
    // Assuming TicketPurchase model tracks purchases
    $ticketsSold = TicketPurchase::where('event_id', $event->id)
                                ->sum('quantity') ?? 0;

    $capacity    = (int) ($event->capacity ?? 0);
    $ticketsLeft = max(0, $capacity - $ticketsSold);

    $status = match (true) {
        $ticketsLeft <= 0   => 'sold_out',
        $ticketsLeft <= 10  => 'low',
        default             => 'available',
    };

    return view('frontend.pages.venueevent', compact(
        'event',
        'ticketsLeft',
        'status'
    ));
    }



    public function onlineevent()
   {
return view('frontend.pages.onlineevent');
   }

     public function pricing()
   {
return view('frontend.pages.pricing');
   }

    public function faq()
   {
return view('frontend.pages.faq');
   }

  public function contactus()
   {
return view('frontend.pages.contactus');
   }

    public function checkout()
   {
return view('frontend.pages.checkout');
   }

     public function booking_confirmed()
   {
return view('frontend.pages.booking_confirmed');
   }

     public function invoice()
   {
return view('frontend.pages.invoice');
   }

     public function attendee_profile()
   {
return view('frontend.pages.attendee');
   }


     public function organiserprofile()
   {
    /// Make sure the user is authenticated (middleware already handles redirect, but good practice)
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    // Get the current organizer's ID
    $organizerId = auth()->id();

    // Fetch only this organizer's events (using the correct column 'user_id')
    $events = Event::where('user_id', $organizerId)
                   ->orderBy('event_date', 'asc')
                   ->get();


return view('frontend.pages.organiserprofile', compact('events'));
   }


   public function organiserdashboard(Request $request)
{

    $period = $request->input('period', 'weekly'); // default to 'weekly'
    $user = Auth::user();

    $events = $user->events()->latest()->get();

    $eventIds = $events->pluck('id');

    $totalRevenue     = Ticket::whereIn('event_id', $eventIds)->sum('price');
    $totalTicketsSold = Ticket::whereIn('event_id', $eventIds)->count();
    $totalPageViews   = $events->sum('views');

    // Pie chart data: revenue per event
    $revenueByEvent = Ticket::whereIn('event_id', $eventIds)
        ->join('events', 'tickets.event_id', '=', 'events.id')
        ->select('events.title', \DB::raw('SUM(tickets.price) as revenue'))
        ->groupBy('events.id', 'events.title')
        ->get();



    $labels = $revenueByEvent->pluck('title')->map(fn($title) => Str::limit($title, 20))->toArray();
    $data   = $revenueByEvent->pluck('revenue')->map(fn($val) => (float)$val)->toArray();

    // Colors for each slice (you can generate dynamically or hardcode)
    $backgroundColors = [
        'rgba(255, 99, 132, 0.7)',  // red
        'rgba(54, 162, 235, 0.7)',  // blue
        'rgba(255, 206, 86, 0.7)',  // yellow
        'rgba(75, 192, 192, 0.7)',  // teal
        'rgba(153, 102, 255, 0.7)', // purple
        'rgba(255, 159, 64, 0.7)',  // orange
    ];

    $chartData = [
        'labels'   => $labels,
        'datasets' => [
            [
                'label'           => 'Revenue (AUD)',
                'data'            => $data,
                'backgroundColor' => array_slice($backgroundColors, 0, count($data)), // cycle colors
                'borderColor'     => '#fff',
                'borderWidth'     => 2,
            ]
        ]
    ];

    return view('frontend.dashboard.organiserdashboard', compact(
        'events', 'totalRevenue', 'totalTicketsSold', 'totalPageViews',
        'chartData', 'period' // keep period if you still use it elsewhere
    ));
}

        public function event_referral_analytics()
   {
return view('frontend.dashboard.event_referral_analytics');
   }

         public function orgevents()
   {
    /// Make sure the user is authenticated (middleware already handles redirect, but good practice)
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Get the current organizer's ID
    $organizerId = auth()->id();

    // Fetch only this organizer's events (using the correct column 'user_id')
    $events = Event::where('user_id', $organizerId)
                   ->orderBy('event_date', 'asc')
                   ->get();

    // Pass the $events collection to the Blade view
    return view('frontend.dashboard.organisationevents', compact('events'));
   }


public function conversion()
{
    // Get all referral sources with counts
    $referrals = BookingItem::select('heard_from', DB::raw('COUNT(*) as total'))
                            ->groupBy('heard_from')
                            ->orderBy('total', 'desc')
                            ->get();

    return view('frontend.dashboard.conversion_setup', compact('referrals'));
}
         public function my_team()
   {
return view('frontend.dashboard.org_my_team');
   }

          public function reports()
   {
return view('frontend.dashboard.org_reports');
   }

           public function payout()
   {
return view('frontend.dashboard.org_payout');
   }

             public function contact_list()
   {
return view('frontend.dashboard.org_contact_list');
   }


     public function online_event()
   {
return view('frontend.createevent.onlineevent');
   }


     public function venue_event()
   {
return view('frontend.createevent.venueevent');
   }


}
