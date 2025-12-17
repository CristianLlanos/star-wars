"use client";

import { useStats } from "@/api/useStats";
import { useEffect } from "react";

function Section({ title, data, unit = "%" }: { title: string; data: Record<string, number>; unit?: string }) {
  const max = Math.max(...Object.values(data));

  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <h2 className="mb-4 text-lg font-semibold text-gray-900">{title}</h2>
      <div className="space-y-3">
        {Object.entries(data).map(([ label, value ]) => (
          <div key={label} className="space-y-1">
            <div className="flex justify-between text-sm text-gray-700">
              <span className="font-medium">{label}</span>
              <span>{value.toFixed(2)}{unit}</span>
            </div>
            <div className="h-2 w-full rounded-full bg-gray-100">
              <div
                className="h-2 rounded-full bg-gray-900 transition-all"
                style={{ width: `${(value / max) * 100}%` }}
              />
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default function DashboardPage() {
  const { stats, isLoading, error, fetchStats } = useStats();

  useEffect(() => {
    fetchStats();
  }, [ fetchStats ]);

  if (isLoading) {
    return (
      <div className="flex items-center justify-center p-6">
        <div className="text-gray-600">Loading...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex items-center justify-center p-6">
        <div className="text-red-600">Error: {error}</div>
      </div>
    );
  }

  return (
    <div className="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
      {stats.top_movie_queries_percentage && (
        <Section
          title="Top 5 Movie Queries"
          data={stats.top_movie_queries_percentage}
          unit="%"
        />
      )}

      {stats.top_person_queries_percentage && (
        <Section
          title="Top 5 Person Queries"
          data={stats.top_person_queries_percentage}
          unit="%"
        />
      )}

      {stats.average_request_time_ms && (
        <Section
          title="Average Request Time"
          data={stats.average_request_time_ms}
          unit=" ms"
        />
      )}

      {stats.popular_hours_percentage && (
        <Section
          title="Popular Hours UTC"
          data={stats.popular_hours_percentage}
          unit="%"
        />
      )}
    </div>
  );
}
