json.array!(@worker_positions) do |worker_position|
  json.extract! worker_position, :id, :description, :estimatedHours, :has_one
  json.url worker_position_url(worker_position, format: :json)
end
